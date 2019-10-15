<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Common\TraitClass\GETConfigTrait;
use App\Common\TraitClass\SmsVerification;
use App\Models\Logic\Specific\UserLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller()
 *
 * @author Administrator
 */
class RegisterController
{

    use GETConfigTrait;
    use SmsVerification;

    /**
     * @Inject()
     *
     * @var UserLogic
     */
    private $logic;

    /**
     * 用户登录操作
     *
     * @author 米糕网络团队 < QQ:2272597637 > <opjklu@126.com>
     * @RequestMapping(route="loginAccount", method=RequestMethod::POST)
     */
    public function loginAccountByShopMGCk(Request $req): array
    {
        $ret = $this->logic->userLogin($req->post());

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * @RequestMapping(route="registerSendMsg", method=RequestMethod::POST)
     *
     * @name 注册发送验证码
     * @author 米糕网络团队
     */
    public function registerSendMsgByShopMGSp(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getRuleByRegSendSms(), $post); 

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        } // 获取失败提示并返回

        $ret = $this->logic->checkUserMobileIsExits($post); // 逻辑处理

        if (!$ret) {
            return AjaxReturn::error('此手机号已经被注册');
        }

        $res = $this->sendVerification($post, $this->logic->getCache());

        if (0 === count($res)) {
            return AjaxReturn::error($this->error);
        }

        return AjaxReturn::sendData(''); // 返回数据
    }

    /**
     * @RequestMapping(route="accountRegister", method=RequestMethod::POST)
     *
     * @name 账户账号注册
     * @author 米糕网络团队
     */
    public function accountRegisterByShopMGCk(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getRuleByAccountRegister(), $post); 

        $status = $checkObj->detectionParameters(); 

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        } // 获取失败提示并返回

        return $this->logic->userAccountRegister($post); // 逻辑处理
    }

    /**
     *
     * @name 短信登录
     * @RequestMapping(route="smsLogin", method=RequestMethod::POST)
     * @Number(name="mobile", min=1)
     * @Number(name="verify", min=1)
     */
    public function smsLoginByShopMGVq(Request $req): array
    {
        $ret = $this->logic->smsUserLogin($req->post()); // 逻辑处理

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        } // 获取失败提示并返回

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * @RequestMapping(route="backPwdSendSms", method=RequestMethod::POST)
     *
     * @name 找回密码 -发送验证码
     */
    public function backPwdSendSmsByShopMGLp(): array
    {
        $this->sendSmsMessage();
    }

    /**
     * @RequestMapping(route="backPwd", method=RequestMethod::POST)
     *
     * @name 修改密码
     */
    public function backPwdByShopMGRi(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getRuleByBackPwd(), $post); 

        $status = $checkObj->detectionParameters(); 

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        } // 获取失败提示并返回

        $ret = $this->logic->backUserPwd($post); // 逻辑处理

        if (!$ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        } // 获取失败提示并返回

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * 短信登录获取验证码
     * @RequestMapping(route="loginSendMsg", method=RequestMethod::POST)
     */
    public function loginSendMsgByShopMGWv(Request $req): array
    {
        return $this->sendSmsMessage($req->post());
    }

    /**
     * 短信登录获取验证码
     */
    private function sendSmsMessage(array $post): array
    {
        $checkObj = new CheckParam($this->logic->getRuleByRegSendSms(), $post); 

        $status = $checkObj->detectionParameters(); 

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        } 

        $res = $this->sendVerification($post, $this->logic->getCache());

        if (0 === count($res)) {
            return AjaxReturn::error($this->error);
        }
        return AjaxReturn::sendData(''); // 返回数据
    }
}