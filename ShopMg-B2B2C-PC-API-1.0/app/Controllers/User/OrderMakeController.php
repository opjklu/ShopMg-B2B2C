<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\CallIsPayReturnClientTrait;
use App\Common\TraitClass\GetGoodsInforByOrderTrait;
use App\Common\TraitClass\ImmediatePaymentTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OrderGoodsLogic;
use App\Models\Logic\Specific\OrderLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 普通订单列表
 * @Controller(prefix="/orderMake")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author Administrator
 */
class OrderMakeController
{
    use CallIsPayReturnClientTrait;

    use ImmediatePaymentTrait;

    use GetGoodsInforByOrderTrait;

    /**
     * @Inject()
     *
     * @var OrderLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var OrderGoodsLogic
     */
    private $orderRelatedLogic;

    /**
     * 个人中心--全部订单
     * @RequestMapping(route="fullOrder", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function fullOrderByShopMGIq(Request $req): array
    {
        $ret = $this->logic->getParseDataByListNoSearch($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }



        $data = $this->getOrderSubsidiaryInformation($ret);

        return AjaxReturn::sendData($data);
    }

    /**
     * 个人中心--搜索订单
     * @RequestMapping(route="orderSearch", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function orderSearchByShopMGUq(Request $req): array
    {
        $ret = $this->logic->getOrder($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('没有搜索到数据');
        }

        $data = $this->getOrderSubsidiaryInformation($ret);

        return AjaxReturn::sendData($data);
    }

    /**
     * 订单附属信息
     *
     * @param array $data
     * @return array
     */
    private function getOrderSubsidiaryInformation(array $data): array
    {
        // 订单商品数据
        $orderGoods = $this->orderRelatedLogic->getOrderGoodsByInfo($data['data'], $this->logic->getPrimaryKey());

        if (0 === count($orderGoods)) {
            return AjaxReturn::error('订单商品异常');
        }
        // 店铺数据
        $data['data'] = $this->storeLogic->getStoreByData($data['data'], $this->logic->getSplitKeyByStore());

        // 商品数据
        $orderGoods = $this->goodsLogic->getGoodsByData($orderGoods, $this->orderRelatedLogic->getSplitKeyByGoods());

        // 商品图片数据
        $orderGoods = $this->goodsImagesLogic->getImageByArrayGoods($orderGoods);

        return [
            'order' => $data,
            'order_goods' => $orderGoods
        ];
    }

    /**
     * 个人中心--评价订单数量
     *
     * @RequestMapping(route="orderCommonNum", method=RequestMethod::POST)
     */
    public function orderCommonNumByShopMGBv(Request $req): array
    {
        $ret = $this->logic->getOrderCommonNum();
        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        return AjaxReturn::sendData($ret['data'], $ret['status'], $ret['message']);
    }

    /**
     * 个人中心--待评价订单
     * @RequestMapping(route="toBeEvaluated", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function toBeEvaluatedByShopMGRx(Request $req): array
    {
        $ret = $this->logic->getToBeEvaluated($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return AjaxReturn::sendData($this->getOrderSubsidiaryInformation($ret));
    }

    /**
     * 个人中心--已评价订单
     * @RequestMapping(route="haveBeenEvaluated", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function haveBeenEvaluatedByShopMGRf(Request $req): array
    {
        $ret = $this->logic->getAlreadyBeEvaluated($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return AjaxReturn::sendData($this->getOrderSubsidiaryInformation($ret));
    }

    /**
     * 个人中心--待付款
     *
     * @RequestMapping(route="pendingPayment", method=RequestMethod::POST)
     */
    public function pendingPaymentByShopMGPh(Request $req): array
    {
        $ret = $this->logic->getPendingPaymentOrder($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return AjaxReturn::sendData($this->getOrderSubsidiaryInformation($ret));
    }

    /**
     * 个人中心--待发货
     *
     * @RequestMapping(route="pendingDelivery", method=RequestMethod::POST)
     */
    public function pendingDeliveryByShopMGDk(Request $req): array
    {
        $ret = $this->logic->getPendingDelivery($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return AjaxReturn::sendData($this->getOrderSubsidiaryInformation($ret));
    }

    /**
     * 个人中心--待收货
     *
     * @RequestMapping(route="goodsToBeReceived", method=RequestMethod::POST)
     */
    public function goodsToBeReceivedByShopMGAx(Request $req): array
    {
        $ret = $this->logic->getGoodsToBeReceived($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return AjaxReturn::sendData($this->getOrderSubsidiaryInformation($ret));
    }

    /**
     * 个人中心--订单回收站
     *
     * @RequestMapping(route="orderRecoveryStation", method=RequestMethod::POST)
     */
    public function orderRecoveryStationByShopMGTt(Request $req): array
    {
       return AjaxReturn::sendData([]);
    }

    /**
     * 个人中心--订单列表删除订单
     *
     * @RequestMapping(route="orderDelByList", method=RequestMethod::POST)
     */
    public function orderDelByListByShopMGVc(Request $req): array
    {
        return AjaxReturn::sendData([]);
    }

    /**
     * 个人中心--订单列表取消订单
     * @RequestMapping(route="orderCancelByList", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function orderCancelByListByShopMGNh(Request $req): array
    {
        $post = $req->post();

        $status = $this->logic->getCancelOrderByList($post);

        if (!$status) {
            return AjaxReturn::error('订单状态修改失败');
        }

        $status = $this->orderRelatedLogic->cancelOrderGooods($post);

        if (!$status) {
            return AjaxReturn::error('订单商品状态修改失败');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 个人中心--删除订单
     * @RequestMapping(route="delOrder", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function delOrderByShopMGHd(Request $req): array
    {
        $post = $req->post();

        $status = $this->logic->delOrders($post);

        if (!$status) {
            return AjaxReturn::error('删除订单失败，另外：已支付的订单不能删除');
        }

        $status = $this->orderRelatedLogic->deleteOrderGooods($post);

        if (!$status) {
            return AjaxReturn::error('订单商品状态修改失败');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 组装 商品信息 用于 减库存。。。
     */
    private function buildPayParam(array $post): bool
    {
        return $this->orderRelatedLogic->statisticalPurchaseQuantity($post, 'id');
    }

    /**
     * 订单 确认收货
     * @RequestMapping(route="confirmGet", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function confirmGetByShopMGQp(Request $req): array
    {
        $post = $req->post();
        
        $ret = $this->logic->confirmGetgoods($post);

        if (false === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        // 修改订单商品
        $status = $this->orderRelatedLogic->confirmGetgoods($post);

        if (!$status) {
            return AjaxReturn::error($this->orderRelatedLogic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 我的订单数量
     * @RequestMapping(route="orderStatusNum", method=RequestMethod::POST)
     *
     * @param Request $req
     * @return array
     */
    public function orderStatusNumByShopMGQm(): array
    {
        $ret = $this->logic->getOrderStatusNum();

        return AjaxReturn::sendData($ret);
    }
}