<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\CallIsPayReturnClientTrait;
use App\Common\TraitClass\GetGoodsInforByOrderTrait;
use App\Common\TraitClass\ImmediatePaymentTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OrderPackageGoodsLogic;
use App\Models\Logic\Specific\OrderPackageLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 套餐订单
 * @Controller(prefix="/orderPackageMake")
 * @Middleware(ValidateLoginMiddleware::class)
 * @author Administrator
 */
class OrderPackageMakeController
{
    use CallIsPayReturnClientTrait;

    use ImmediatePaymentTrait;

    use GetGoodsInforByOrderTrait;

    /**
     * @Inject()
     *
     * @var OrderPackageLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var OrderPackageGoodsLogic
     */
    private $orderRelatedLogic;

    /**
     * 我的订单--全部订单
     * @RequestMapping(route="fullOrder", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function fullOrderByShopMGCe(Request $req): array
    {
        $ret = $this->logic->getParseDataByListNoSearch($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return $this->common($ret);
    }

    /**
     * 个人中心--搜索订单
     * @RequestMapping(route="orderSearch", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function orderSearchByShopMGLc(Request $req): array
    {
        $ret = $this->logic->getOrder($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('没有搜索到数据');
        }

        return $this->common($ret);
    }

    /**
     * 我的订单--待付款
     * @RequestMapping(route="pendingPayment", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function pendingPaymentByShopMGCb(Request $req): array
    {
        $ret = $this->logic->getPendingPaymentOrderList($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return $this->common($ret);
    }

    /**
     * 我的订单--待发货
     * @RequestMapping(route="pendingDelivery", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function pendingDeliveryByShopMGFu(Request $req): array
    {
        $ret = $this->logic->getPendingDelivery($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        $this->common($ret);
    }

    /**
     * 我的订单--待收货
     * @RequestMapping(route="goodsToBeReceived", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function goodsToBeReceivedByShopMGMo(Request $req): array
    {
        $ret = $this->logic->getGoodsToBeReceived($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return $this->common($ret);
    }

    /**
     * 我的订单--待评价
     * @RequestMapping(route="toBeEvaluated", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function toBeEvaluatedByShopMGKe(Request $req): array
    {
        $ret = $this->logic->getToBeEvaluated($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return $this->common($ret);
    }

    /**
     * 我的订单--已评价
     * @RequestMapping(route="alreadyEvaluated", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function alreadyEvaluatedByShopMGDq(Request $req): array
    {
        $ret = $this->logic->getAlreadyEvaluated($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return $this->common($ret);
    }

    /**
     * 我的订单--已取消
     * @RequestMapping(route="haveBeenCancelled", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function haveBeenCancelledByShopMGLq(Request $req): array
    {
        $ret = $this->logic->getHaveBeenCancelled($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return $this->common($ret);
    }

    /**
     * 我的订单--已完成
     * @RequestMapping(route="completed", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function completedByShopMGOl(Request $req): array
    {
        $ret = $this->logic->getCompleted($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        }
        return $this->common($ret);
    }

    /**
     * 退货 获取详情 获取
     * @RequestMapping(route="returnGoods")
     */
    public function returnGoodsByShopMGVc(Request $req): array
    {
    }

    /**
     * 删除订单--修改状态
     * @RequestMapping(route="orderDel", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function orderDelByShopMGCd(Request $req): array
    {
        $ret = $this->logic->orderDel($req->post());
        if (0 === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 取消订单
     * @RequestMapping(route="cancelOrder", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function cancelOrderByShopMGNw(Request $req): array
    {
        $ret = $this->logic->delete($req->post());

        if (0 === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 我的订单--订单再次购买
     * @RequestMapping(route="buyAgain", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function buyAgainByShopMGDv(Request $req): array
    {
        $ret = $this->logic->getBuyAgain();
        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        return AjaxReturn::sendData($ret['data'], $ret['status'], $ret['message']);
    }

    /**
     * 公共方法
     *
     * @param array $ret
     */
    private function common(array $ret): array
    {
        $orderPackageData = $this->orderRelatedLogic->getPackageOrderGoodsInfo($ret['data'], $this->logic->getPrimaryKey());

        if (0 === count($orderPackageData)) {
            return AjaxReturn::error('套餐商品异常');
        }

        $goodsData = $this->goodsLogic->getGoodsByData($orderPackageData, $this->orderRelatedLogic->getSplitKeyByGoods());

        $goodsData = $this->goodsImagesLogic->getImageByArrayGoods($goodsData);

        return AjaxReturn::sendData([
            'order' => $ret['data'],
            'goods' => $goodsData,
            'page' => $ret['count'],
            'page_size' => $ret['page_size']
        ]);
    }

    /**
     * 订单 确认收货
     * @RequestMapping(route="confirmGet", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function confirmGetByShopMGKe(Request $req): array
    {
        $post = $req->post();

        $ret = $this->logic->confirmGetgoods($post);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        // 修改订单商品

        $status = $this->orderRelatedLogic->confirmGet($post);

        if (!$status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}