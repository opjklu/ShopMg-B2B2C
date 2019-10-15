<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\GETConfigTrait;
use App\Common\TraitClass\SmsVerification;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\AccountSecurityLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Bean\Annotation\Strings;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 账户安全
 *
 * @Controller(prefix="/accountSecurity")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class AccountSecurityController
{
    use SmsVerification;
    use GETConfigTrait;

    /**
     * @Inject()
     *
     * @var AccountSecurityLogic
     */
    private $logic;

    /**
     *
     * @name 账户安全-验证码 :多用
     * @RequestMapping(route="accountSecurityVerify", method=RequestMethod::GET)
     */
    public function accountSecurityVerifyByShopMGSg(Request $req): string
    {
        return $this->logic->verify();
    }

    /**
     *
     * @name 账户安全-验证验证码 :多用
     *
     * @RequestMapping(route="accountSecurityCheckVerify", method=RequestMethod::POST)
     */
    public function accountSecurityCheckVerifyByShopMGWv(Request $req): array
    {
       return AjaxReturn::sendData('');
    }

    /**
     *
     * @name 账户安全-修改密码-登录密码验证：第一步 验证身份
     *
     * @RequestMapping(route="verificationPassword", method=RequestMethod::POST)
     * @Number(name="type", min=0)
     * @Strings(name="password")
     * @Strings(name="vertify")
     * @return array
     */
    public function verificationPasswordByShopMGDt(Request $req): array
    {

        $result = $this->logic->editUpdatePassword($req->post());

        if (false === $result) {
            return AjaxReturn::error('验证密码错误');
        }

        return AjaxReturn::sendData($result);
    }

    /**
     * 账户安全-修改密码-新密码：第二步
     *
     * @RequestMapping(route="modifyPassword", method=RequestMethod::POST)
     * @Strings(name="newpassword")
     * @param Request $req
     * @return array
     */
    public function modifyPasswordByShopMGOp(Request $req): array
    {
        $result = $this->logic->newPassword($req->post());


        if (0 === $result) {
            return AjaxReturn::error('修改密码错误');
        }

        return AjaxReturn::sendData($result);
    }

    /**
     *
     * @name 账户安全-邮箱验证:第二步-发送邮件-多用
     * @RequestMapping(route="sendMailbox", method=RequestMethod::POST)
     * @Strings(name="email", template="/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i")
     * @return array
     */
    public function sendMailboxByShopMGMc(Request $req): array
    {
        return $this->logic->addmailbox($req->post());
    }

    /**
     *
     * @name 账户安全-邮箱验证:第二步-验证邮件
     * @RequestMapping(route="verifMailbox", method=RequestMethod::POST)
     * @Number(name="code", min=1)
     * @return array
     */
    public function verifMailboxByShopMGEo(Request $req): array
    {
        return $this->logic->checkEmail($req->post());
    }

    /**
     * 发送手机验证码（修改密码）
     * @RequestMapping(route="sendPhoneNumber", method=RequestMethod::POST)
     */
    public function sendPhoneNumberByShopMGFs(Request $req): array
    {
        $post = $req->post();

        $checkParam = new CheckParam($this->logic->getValidatePhone(), $post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }

        $receive = $this->sendVerificationByEditPassWord($post, $this->logic->getCache());

        if (0 === count($receive)) {
            return AjaxReturn::error($this->error);
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 发送手机验证码（修改手机号码）
     * @RequestMapping(route="sendPhoneNumberByEditPhone", method=RequestMethod::POST)
     */
    public function sendPhoneNumberByEditPhoneByShopMGDg(Request $req): array
    {
        $post = $req->post();

        $checkParam = new CheckParam($this->logic->getValidatePhone(), $post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }

        $receive = $this->sendVerificationByInformationChange($post, $this->logic->getCache());

        if (0 === count($receive)) {
            return AjaxReturn::error($this->error);
        }

        return AjaxReturn::sendData($receive);
    }

    /**
     *
     * @name 账户安全-验证短信验证码 （修改手机号）
     * @RequestMapping(route="shortMessageVerification", method=RequestMethod::POST)
     */
    public function shortMessageVerificationByShopMGSt(Request $req): array
    {
        $post = $req->post();

        $checkParam = new CheckParam($this->logic->getValidateByEditMobile(), $post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }
        $result = $this->logic->getShortMassageVerification($post);

        if (!$result) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * @name 账户安全-修改绑定手机:第二步
     * @RequestMapping(route="modifyIphone", method=RequestMethod::POST)
     */
    public function modifyIphoneByShopMGEw(Request $req): array
    {
        $post = $req->post();

        $checkParam = new CheckParam($this->logic->getValidateByEditMobile(), $post);

        if (!$checkParam->detectionParameters()) {
            return AjaxReturn::error($checkParam->getErrorMessage());
        }
        $result = $this->logic->getShortMassageVerif($post);

        if (!$result) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}