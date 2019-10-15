<?php

namespace App\Controllers\Home;

use App\Models\Logic\Specific\StoreHelpLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/storeHelp")
 *
 * @author wq
 *
 */
class StoreHelpController
{



    /**
     * @Inject()
     *
     * @var StoreHelpLogic
     */
    private $logic;

    /**
     * 入驻流程
     *
     * @RequestMapping(route="enterFlow")
     */
    public function enterFlowByShopMGQf(Request $req): array
    {
        // 检测传值 //检测方法
        $ret = $this->logic->enter_flow("入驻流程");

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 招商标准
     *
     * @RequestMapping(route="standardOfInvestment")
     */
    public function standardOfInvestmentByShopMGAl(Request $req): array
    {
        // 检测传值 //检测方法
        $ret = $this->logic->enter_flow("入驻标准");

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 合作细则
     *
     * @RequestMapping(route="rulesOfCooperation")
     */
    public function rulesOfCooperationByShopMGVu(Request $req): array
    {
        // 检测传值 //检测方法
        $ret = $this->logic->enter_flow("合作细则");

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    public function agreementOfInvestmentByShopMGRc(Request $req): array
    {
        // 检测传值 //检测方法
        $ret = $this->logic->enter_flow("入驻协议");

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }
}