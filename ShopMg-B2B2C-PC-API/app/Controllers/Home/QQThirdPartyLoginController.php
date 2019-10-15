<?php

namespace App\Controllers\Home;

use App\Common\Tool\Extend\CURL;
use App\Common\TraitClass\GETConfigTrait;
use App\Models\Logic\Specific\UserAuthLogic;
use Swoft\App;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;

/**
 * @Controller()
 * QQ 登录
 *
 * @author 米糕网络团队
 *
 */
class QQThirdPartyLoginController
{

    use GETConfigTrait;

    private $loginURL = 'https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=';

    private $callBackURL = 'https://graph.qq.com/oauth2.0/token';

    private $graphURL = 'https://graph.qq.com/oauth2.0/me';

    private $userInfo = 'https://graph.qq.com/user/get_user_info';

    /**
     * QQ登录
     * @RequestMapping(route="qqLogin")
     */
    public function qqLoginByShopMGRn()
    {
        $config = $this->getGroupConfig('qq_party_login');

        $state = md5(uniqid(rand(), TRUE)); // CSRF protection

        session()->put('state', $state);

        $url = config('qq_redirect_url');

        session()->put('qq_url', $url);

        $loginURL = $this->loginURL . $config['app_id'] . '&redirect_uri=' . urlencode($url) . '&state=' . $state . '&scope=get_user_info';

        return AjaxReturn::sendData($loginURL);
    }

    /**
     * qq 回调
     * @RequestMapping(route="qqLoginCallBack", method={RequestMethod::GET})
     */
    public function qqLoginCallBackByShopMGHp(Request $request, Response $response)
    {
        $get = $request->query();
        
        if ($get['state'] !== session()->get('state')) {
            return $response->redirect(config('auth_error_url') . '/' . urlencode('参数不合法'));
        }

        $param = $this->getCallBack($get);

        if (empty($param)) {
            return $response->redirect(config('auth_error_url') . '/' . urlencode('获取access_token失败'));
        }

        $data = $this->getOpenId($param);

        if (empty($data)) {
            return $response->redirect(config('auth_error_url'));
        }

        $param['identity_type'] = '1';

        $param = array_merge($param, $data);

        $authLogic = App::getBean(UserAuthLogic::class);

        $result = $authLogic->checkGrantByQQ($param);

        $refreshToken = [];

        // 标记变量
        $flag = 0;

        $isLate = $authLogic->getIsLate();

        if (!empty($result) && $isLate === false) {
            session()->put('user_id', $result['user_id']);
            return $response->redirect(config('mobile') . '?auth_token=' . session()->getId());
        }
        if (!empty($result) && $isLate === true) {
            $flag = 1;
            // 授权过期，重新授权
            $refreshToken = $this->refreshAuth($result);
        }

        if ($flag === 1 && empty($refreshToken)) {
            return $response->redirect(config('auth_error_url') . '/' . urlencode('重新授权失败'));
        }

        $status = 0;

        $isUpdate = 0;

        if ($flag === 1 && !empty($refreshToken)) {

            $result['credential'] = $refreshToken['access_token'];

            $result['expires_in'] = $refreshToken['expires_in'];

            $result['refresh_token'] = $refreshToken['refresh_token'];

            $result['update_at'] = time();

            $authLogic->setData($result);

            $status = $authLogic->saveData();

            $isUpdate = 1;
        }

        if ($status === 0 && $isUpdate === 1) {
            return $response->redirect(config('auth_error_url') . '/' . urlencode('保存授权信息失败'));
        }

        if ($status !== 0 && $isUpdate === 1) {
            session()->put('user_id', $result['user_id']);
            return $response->redirect(config('mobile'));
        }

        $userInfo = $this->getUeserInfo($param['access_token'], $data['openid']);

        if (empty($userInfo)) {
            return $response->redirect(config('auth_error_url') . '/' . urlencode('获取open_id失败'));
        }

        session()->put('open_id_data', $data);

        session()->put('user_info_qq', $userInfo);

        session()->put('access_token', $param);

        session()->put('identitifer', '1');

        return $response->redirect(config('add_user_info') . '/111');

    }

    /**
     * 获取callback
     *
     * @return number[]|array[]|NULL[]|array
     */
    private function getCallBack(array $get)
    {
        $qqURL = session('qq_url')->get();

        if (empty($qqURL)) {
            return [];
        }

        $config = $this->getGroupConfig('qq_party_login');

        $param = [
            'grant_type' => 'authorization_code',
            'client_id' => $config['app_id'],
            'redirect_uri' => $qqURL,
            'client_secret' => $config['qq_key'],
            'code' => $get['code']
        ];

        file_put_contents('./Log/qq/token_url_id.txt', print_r($param, true) . "\r\n", FILE_APPEND);

        $response = (new CURL($param, $this->callBackURL))->curlByGet();

        file_put_contents('./Log/qq/qq_response_id.txt', print_r($response, true) . "\r\n", FILE_APPEND);

        if (strpos($response, "callback") !== false) {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos - 1);
            $msg = json_decode($response);
            if (isset($msg->error)) {
                return [];
            }
        }

        $params = array();
        parse_str($response, $params);

        file_put_contents('./Log/qq/qq_param_id.txt', print_r($params, true));

        return $params;
    }

    /**
     * 获取open id
     *
     * @param array $data
     */
    private function getOpenId(array $data)
    {
        $args = [
            'access_token' => $data['access_token']
        ];

        $str = (new CURL($args, $this->graphURL))->curlByGet();

        if (strpos($str, "callback") !== false) {
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str = substr($str, $lpos + 1, $rpos - $lpos - 1);
        }

        $user = json_decode($str, true);

        if (isset($user['error'])) {
            return [];
        }

        return $user;
    }

    /**
     * 获取用户数据
     */
    private function getUeserInfo($accesToken, $openId)
    {
        $config = $this->getGroupConfig('qq_party_login');

        $data = [
            'access_token' => $accesToken,
            'oauth_consumer_key' => $config['app_id'],
            'openid' => $openId
        ];

        $json = (new CURL($data, $this->userInfo))->curlByGet();

        $json = json_decode($json, true);

        return $json;
    }

    /**
     * 重新授权
     */
    private function refreshAuth(array $data)
    {
        $config = $this->getGroupConfig('qq_party_login');

        $param = [
            'grant_type' => 'refresh_token',
            'client_id' => $config['app_id'],
            'client_secret' => $config['qq_key'],
            'refresh_token' => $data['refresh_token']
        ];

        $response = (new CURL($param, $this->callBackURL))->curlByGet();

        if (strpos($response, "callback") !== false) {
            return [];
        }

        $param = [];

        parse_str($response, $param);

        return $param;
    }
}