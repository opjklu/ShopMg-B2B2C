<?php

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\BalanceLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 收货地址
 * @Controller(perfix="balance")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class BalanceController
{

    /**
     * @Inject()
     *
     * @var BalanceLogic
     */
    private $logic;

    /**
     * @RequestMapping(route="getDetailsType", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @name 我的账户-交易明细
     * @return array
     * @author 米糕网络团队
     */
    public function getDetailsTypeByShopMGWj(Request $req): array
    {
        $ret = $this->logic->getParseDataByListNoSearch($req->post());

        return AjaxReturn::sendData($ret);
    }

    /**
     * @RequestMapping(route="getDetailsIncome", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @name 我的账户-收入
     * @return array
     * @author 米糕网络团队
     */
    public function getDetailsIncomeByShopMGPi(Request $req): array
    {
        $ret = $this->logic->getDetailsIncome($req->post()); // 逻辑处理

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * @RequestMapping(route="getDetailsPay", method=RequestMethod::POST)
     *
     * @name 我的账户-支出
     * @return array
     * @author 米糕网络团队
     */
    public function getDetailsPayByShopMGDc(Request $req): array
    {
        $ret = $this->logic->getDetailsPay($req->post()); // 逻辑处理

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * @RequestMapping(route="getDetailsAccount", method=RequestMethod::POST)
     *
     * @name 我的账户-绑定提现账号
     * @author 米糕网络团队
     */
    public function getDetailsAccountByShopMGUa(Request $req): array
    {
        return AjaxReturn::sendData('');
    }
}