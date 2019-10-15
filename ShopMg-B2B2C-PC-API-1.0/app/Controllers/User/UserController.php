<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\UserDataLogic;
use App\Models\Logic\Specific\UserLevelLogic;
use App\Models\Logic\Specific\UserLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Strings;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * @Controller(prefix="/user")
 *
 * @author wq
 * @Middleware(ValidateLoginMiddleware::class)
 */
class UserController
{

    /**
     * @Inject()
     *
     * @var UserLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var UserDataLogic
     */
    private $userDatalogic;

    /**
     * @Inject()
     *
     * @var UserLevelLogic
     */
    private $userLevellogic;

    /**
     * 会员中心--基本资料
     * @RequestMapping(route="userInfo", method=RequestMethod::POST)
     */
    public function userInfoByShopMGGq(): array
    {
        $result = $this->logic->getUserInfo();

        if (count($result) === 0) {
            return AjaxReturn::error('用户信息错误');
        }

        $integral = $this->userDatalogic->getIntegralByUserIdCache();

        $userLevelParse = $this->userLevellogic->parseUserNextLevel($integral, $this->userDatalogic->getSplitKeyByIntegral());

        $result = array_merge($result, $userLevelParse);

        return AjaxReturn::sendData($result);
    }

    /**
     * 会员中心--基本资料--修改
     * @RequestMapping(route="userInfoEdit", method=RequestMethod::POST)
     */
    public function userInfoEditByShopMGHg(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getRuleByEditUserInfo(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }
        $result = $this->logic->editUserInfo($post);

        return AjaxReturn::sendData($result);
    }

    /**
     * 会员中心--账户安全--获取用户资料
     * @RequestMapping(route="userSecurityDetails", method=RequestMethod::POST)
     */
    public function userSecurityDetailsByShopMGRb(): array
    {
        return AjaxReturn::sendData($this->logic->getUserInfo());
    }

    /**
     * 身份认证
     * @RequestMapping(route="identityAuthentication", method=RequestMethod::POST)
     */
    public function identityAuthenticationByShopMGVk(Request $request): array
    {
        $post = $request->post();

        $checkParam = new CheckParam($this->logic->getValidateByIdCard(), $post);

        if (false === $checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }
        $status = $this->logic->authentication($post);

        if(false === $status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}