<?php

namespace App\Controllers\Home;


use App\Models\Logic\Specific\CouponListLogic;
use App\Models\Logic\Specific\GoodsPackageCartLogic;
use App\Models\Logic\Specific\OrderPackageGoodsLogic;
use App\Models\Logic\Specific\OrderPackageInvoiceLogic;
use App\Models\Logic\Specific\OrderPackageLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Tool\SessionManager;

/**
 * @Controller()
 *
 * @author Administrator
 *
 */
class OrderPackageController
{

    /**
     * @Inject()
     *
     * @var OrderPackageLogic
     */
    private $logic;

    /**
     * 发票逻辑
     * @Inject()
     *
     * @var OrderPackageInvoiceLogic
     */
    private $orderInvoiceLogic;

    /**
     * @Inject()
     *
     * @var OrderPackageGoodsLogic
     */
    private $orderGoodsLogic;

    /**
     * 发票逻辑
     * @Inject()
     *
     * @var CouponListLogic
     */
    private $couponListLogic;

    /**
     * @Inject()
     *
     * @var GoodsPackageCartLogic
     */
    private $goodsPackageCartLogic;

    /**
     * 生成订单--立即购买
     * @Number(name="address_id", min=1)
     *
     * @author 米糕网络
     * @RequestMapping(route="orderBegin", method={RequestMethod::POST})
     */
    public function orderBeginByShopMGKg(Request $req): array
    {
        $payData = $this->buildOrderCompont($req->post());

        if (0 === count($payData)) {
            return AjaxReturn::error('生成订单失败');
        }

        // 支付数据
        SessionManager::SET_ORDER_DATA($payData);

        SessionManager::REMOVE_GOODS_DATA_SOURCE();

        return AjaxReturn::sendData('');
    }

    /**
     *
     * @param array $post
     * @return array
     */
    private function buildOrderCompont(array $post): array
    {
        $ret = $this->logic->orderBegin($post);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        list ($payData, $invoiceData, $insertArray) = $ret;

        $status = $this->orderGoodsLogic->buildOrderGoods($insertArray);

        if (!$status) {
            return [];
        } // 发票更新

        $status = $this->orderInvoiceLogic->updateInvoice($invoiceData);

        if (!$status) {
            return [];
        }

        $status = $this->couponListLogic->couponParse($payData);

        if (!$status) {
            return [];
        }

        return $payData;
    }

    /**
     * 生成订单--购物车购买
     *
     * @author @RequestMapping(route="orderBeginByCart")
     */
    public function orderBeginByCartByShopMGNb(Request $req): array
    {
        $payData = $this->buildOrderCompont($req->post());

        if (0 === count($payData)) {
            return AjaxReturn::error('生成订单失败');
        }

        $status = $this->goodsPackageCartLogic->deletePackageCart();

        if (!$status) {
            return AjaxReturn::error($this->goodsPackageCartLogic->getErrorMessage());
        }

        SessionManager::REMOVE_GOODS_DATA_SOURCE();

        return AjaxReturn::sendData($status);
    }
}