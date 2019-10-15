<?php

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\ComplainLogic;
use App\Models\Logic\Specific\OrderLogic;
use App\Models\Logic\Specific\StoreLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Bean\Annotation\Strings;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 *
 * @author wq
 *
 * @Controller(prefix="/complain")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class ComplainController
{
    /**
     * @Inject()
     *
     * @var ComplainLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var OrderLogic
     */
    private $orderLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * 我的订单--投诉申请
     *
     * @RequestMapping(route="myComplain", method={RequestMethod::POST})
     * @Number(name="store_id", min=1)
     * @Number(name="order_id", min=1)
     * @Number(name="order_goods_id", min=1)
     * @Number(name="complain_id", min=1)
     * @Strings(name="complain_pic1")
     * @Strings(name="complain_pic2")
     * @Strings(name="complain_pic3")
     */
    public function myComplainByShopMGDm(Request $req): array
    {
        $result = $this->logic->addData($req->post());

        if (0 === $result) {
            return AjaxReturn::error('添加失败');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 我的订单--投诉申请列表
     *
     * @param Request $req
     * @return array
     * @author 米糕网络团队
     * @RequestMapping(route="complainList", method={RequestMethod::POST})
     * @Number(name="page", min=1)
     */
    public function complainListByShopMGWf(Request $req): array
    {
        $data = $this->logic->getParseDataByList($req->post());

        if (0 === count($data)) {
            return AjaxReturn::error('投诉列表为空');
        }

        $data = $this->orderLogic->getOrderSnByData($data, $this->logic->getSplitKeyByOrderId());

        $data = $this->storeLogic->getStoreByContrast($data, $this->logic->getSplitKeyByStoreId());

        return AjaxReturn::sendData($data);
    }

    /**
     * 我的订单--删除投诉
     *
     * @author 米糕网络团队
     * @RequestMapping(route="ComplainDel", method={RequestMethod::POST})
     * @Number(name="id", min=1)
     */
    public function ComplainDelByShopMGHn(Request $req): array
    {

        $result = $this->logic->delete($req->post());

        if (0 === $result) {
            return AjaxReturn::error('删除失败');
        }

        return AjaxReturn::sendData('');   
    }
}
