<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\OrderLogic;
use Validate\CheckParam;
use App\Models\Logic\Specific\OrderGoodsLogic;
use App\Models\Logic\Specific\OrderInvoiceLogic;
use App\Models\Logic\Specific\CouponListLogic;
use App\Models\Logic\Specific\GoodsCartLogic;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Tool\AjaxReturn;
use Tool\SessionManager;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use App\Middlewares\ValidateLoginMiddleware;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;

/**
 * @Controller()
 * @Middleware(ValidateLoginMiddleware::class)
 * 生成订单
 *
 * @author Administrator
 */
class GeneratingOrderController
{

    /**
     * 订单商品逻辑
     * @Inject()
     *
     * @var OrderGoodsLogic
     */
    private $orderGoodsLogic;

    /**
     * @Inject()
     *
     * @var OrderLogic
     */
    private $logic;

    /**
     * 发票逻辑
     * @Inject()
     *
     * @var OrderInvoiceLogic
     */
    private $orderInvoiceLogic;

    /**
     * 发票逻辑
     * @Inject()
     *
     * @var CouponListLogic
     */
    private $couponListLogic;

    /**
     * 发票逻辑
     * @Inject()
     *
     * @var GoodsCartLogic
     */
    private $goodsCartLogic;

    /**
     * 配件立即购买
     * @RequestMapping(route="partsBuyNow", method=RequestMethod::POST)
     */
    public function partsBuyNowByShopMGGw(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getMessageValidateByParts(), $post);

        if (false === $checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $payData = $this->commonMultiCommodityGeneratedOrder($post);

        if (count($payData) === 0) {
            return AjaxReturn::error('生成订单失败');
        }
        $this->logic->submitTranstion();

        // 支付数据
        SessionManager::SET_ORDER_DATA($payData);

        // 普通订单 0 套餐订单 1
        SessionManager::SET_ORDER_TYPE_BY_USER(0);

        SessionManager::REMOVE_GOODS_DATA_SOURCE();

        return AjaxReturn::sendData('');
    }

    /**
     * *
     * 在商品列表直接购买商品->直接下单
     * @RequestMapping(route="orderBeginFromGood", method=RequestMethod::POST)
     */
    public function orderBeginFromGoodByShopMGPj(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidateByGoods(), $post);

        $status = $checkObj->detectionParameters();

        if (false === $status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->placeTheOrder($post);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        list ($payData, $invoiceData, $insertId) = $ret;

        $status = $this->orderGoodsLogic->placeTheOrderGoods([
            'order_id' => $insertId
        ]);

        if (!$status) {
            return AjaxReturn::error($this->orderGoodsLogic->getErrorMessage());
        }

        // 发票更新
        $status = $this->orderInvoiceLogic->updateInvoiceByPlaceTheOrder($invoiceData);

        if (!$status) {
            return AjaxReturn::error($this->orderInvoiceLogic->getErrorMessage());
        }

        // 支付的时候需要的订单数据
        // 是否更新优惠券
        $status = $this->couponListLogic->couponParse([
            $payData
        ]);

        if (!$status) {
            return AjaxReturn::error($this->couponListLogic->getErrorMessage());
        }

        $this->logic->submitTranstion();

        // 支付数据
        SessionManager::SET_ORDER_DATA([
            $payData
        ]);

        SessionManager::SET_ORDER_TYPE_BY_USER(0);

        SessionManager::REMOVE_GOODS_DATA_SOURCE();

        return AjaxReturn::sendData($ret);
    }

    /**
     * 购物车->去结算
     * @RequestMapping(route="buildOrderByCart", method=RequestMethod::POST)
     * @Number(name="address_id", min=1)
     */
    public function buildOrderByCartByShopMGHk(Request $req): array
    {
        $payData = $this->commonMultiCommodityGeneratedOrder($req->post());

        if (count($payData) === 0) {
            return AjaxReturn::error('生成订单失败');
        }

        // 删除购物车
        $status = $this->goodsCartLogic->deleteCartByTrans($this->orderGoodsLogic->getCartId());

        if (!$status) {
            return AjaxReturn::error($this->goodsCartLogic->getErrorMessage());
        }
        // 支付数据
        SessionManager::SET_ORDER_DATA($payData);

        // 普通订单 0 套餐订单 1
        SessionManager::SET_ORDER_TYPE_BY_USER(0);

        SessionManager::REMOVE_GOODS_DATA_SOURCE();

        return AjaxReturn::sendData('');
    }

    /**
     * 订单公共数据处理
     */
    private function commonMultiCommodityGeneratedOrder(array $post): array
    {
        $ret = $this->logic->multiCommodityGeneratedOrder($post);

        if (0 === count($ret)) {
            return [];
        }

        list ($payData, $invoiceData, $insertArray) = $ret;

        $status = $this->orderGoodsLogic->buildOrderGoods($insertArray);

        if (!$status) {
            return [];
        }
        // 发票更新
        $status = $this->orderInvoiceLogic->updateInvoice($invoiceData);

        if (!$status) {
            return [];
        }
        // 支付的时候需要的订单数据

        // 是否更新优惠券

        $status = $this->couponListLogic->couponParse($payData);

        if (!$status) {
            return [];
        }

        return $payData;
    }
}