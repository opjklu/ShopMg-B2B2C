<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Common\TraitClass;

use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\IntegralUseLogic;
use App\Models\Logic\Specific\OrderGoodsLogic;
use App\Models\Logic\Specific\OrderIntegralGoodsLogic;
use App\Models\Logic\Specific\OrderIntegralLogic;
use App\Models\Logic\Specific\OrderLogic;
use App\Models\Logic\Specific\OrderPackageGoodsLogic;
use App\Models\Logic\Specific\OrderPackageLogic;
use App\Models\Logic\Specific\StoreLogic;
use App\Models\Logic\Specific\StoreMemberLevelLogic;
use App\Models\Logic\Specific\StoreMemberLogic;
use App\Models\Logic\Specific\UserDataLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Log\Log;
use Tool\Hook;
use Tool\SessionManager;

/**
 * 支付通知
 *
 * @author Administrator
 */
trait OrderNoticeTrait
{

    private $payReturnData = [];

    private $errorMessage;

    /**
     * 订单类型
     *
     * @var integer
     */
    protected $orderType;

    /**
     * 0 普通订单
     * @Inject()
     *
     * @var OrderLogic
     */
    private $orderLogic;

    /**
     * 1优惠套餐订单
     * @Inject()
     *
     * @var OrderPackageLogic
     */
    private $orderPackageLogic;

    /**
     * 2 积分订单
     * @Inject()
     *
     * @var OrderIntegralLogic
     */
    private $orderIntegralLogic;

    /**
     * @Inject()
     *
     * @var OrderGoodsLogic
     */
    private $orderGoodsLogic;

    /**
     * @Inject()
     *
     * @var OrderPackageGoodsLogic
     */
    private $orderPackageGoodsLogic;

    /**
     * @Inject()
     *
     * @var OrderIntegralGoodsLogic
     */
    private $orderIntegralGoodsLogic;

    /**
     * @Inject()
     *
     * @var IntegralUseLogic
     */
    private $integralUseLogic;

    /**
     * @Inject()
     *
     * @var UserDataLogic
     */
    private $userDataLogic;

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * @Inject()
     *
     * @var StoreMemberLogic
     */
    private $storeMemberLogic;

    /**
     * @Inject()
     *
     * @var StoreMemberLevelLogic
     */
    private $storeMemberLevelLogic;

    /**
     * 0 普通订单 1优惠套餐订单 2 积分订单
     *
     * @return array
     */
    private function orderParseClass(): array
    {
        return [
            $this->orderLogic,
            $this->orderPackageLogic,
            $this->orderIntegralLogic
        ];
    }

    /**
     *
     * @return the $orderGoodsParseClass
     */
    private function getOrderGoodsParseClass(): array
    {
        return [
            $this->orderGoodsLogic,
            $this->orderPackageGoodsLogic,
            $this->orderIntegralGoodsLogic
        ];
    }

    /**
     * 积分比例
     *
     * @param float $payIntegral
     *            积分比例
     * @param string $tradeNo
     *            支付宝流水号
     * @return boolean
     */
    private function orderNotice(float $payIntegral, string $tradeNo = ''): bool
    {
        $payConf = session()->get('pay_config_by_user');

        if (0 === count($payConf)) {
            $this->errorMessage = '参数错误';

            Log::error('订单处理--没有对应的支付配置数据');
            return false;
        }

        $orderParseClass = $this->orderParseClass();

        if (!isset($orderParseClass[$this->orderType])) {
            $this->errorMessage = '没有对应的订单类型';
            Log::error('订单处理--没有对应的订单类型');
            return false;
        }

        $orderData = SessionManager::GET_ORDER_DATA();

        // 订单操作
        {
            try {
                // 订单类型序号
                $class = $orderParseClass[$this->orderType];

                $orderId = array_column($orderData, 'order_id');

                $status = $class->paySuccessEditStatus($orderId, $payConf);
            } catch (\Exception $e) {

                Log::error('订单处理--' . $e->getMessage(), $orderData);

                return false;
            }

            if (!$status) {

                Log::error('订单处理--修改订单状态失败或者已修改成功');
                $this->errorMessage = '修改订单状态失败或者已修改成功';
                return false;
            }

            try {

                $refOrderGoodsClass = $this->getOrderGoodsParseClass()[$this->orderType];

                $status = $refOrderGoodsClass->updateOrderGoodsStatus($orderId);
            } catch (\Exception $e) {
                Log::error('订单状态 -- ' . $e->getMessage(), $orderData);
                return false;
            }

            if (!$status) {
                $this->errorMessage = '订单商品状态操作错误';
                Log::error('订单状态 -- ', $orderData);
                return false;
            }
        }

        // 事件监听 回调数据
        $param = [
            'order_id' => $orderId,
            'trade_no' => $tradeNo,
            'wx_order_id' => $orderId,
            'type' => $this->orderType
        ];

        Hook::listen('aplipaySerial', $param);

        if (empty($param)) {

            Log::error('第三方支付配置 -- ', $param);

            $this->errorMessage = '生成标志失败';
            return false;
        }

        // 积分操作
        {
            if ($this->orderType != 2) {

                $receive = $this->integralUseLogic->addIntegral($orderData, $payIntegral);

                if ($receive['status'] === false) {

                    Log::error('积分操作错误', $orderData);

                    $this->errorMessage = '积分操作错误';
                    return false;
                }

                $totalIntegral = $receive['total_number'];

                if ($totalIntegral !== 0) {

                    // 统计积分加入用户数据表，防止积分支付频繁读取
                    $sataus = $this->userDataLogic->updateIntegralByAdd([
                        'total_integral' => $totalIntegral
                    ]);

                    if ($sataus === false) {

                        Log::error('订单状态' . $status . '-积分-' . $totalIntegral);
                        return false;
                    }
                }
            }
        }

        $orderGoodsData = SessionManager::GET_ORDER_GOODS_DATA();

        // 减库存
        $status = $this->goodsLogic->delStock($orderGoodsData);

        if (empty($status)) {
            $this->errorMessage = $this->goodsLogic->getErrorMessage();
            return false;
        }

        // 店铺增加销量

        $status = $this->storeLogic->updateSale($orderData);

        if (empty($status)) {
            $this->errorMessage = $this->storeLogic->getErrorMessage();

            Log::error('店铺增加销量-- ' . $this->errorMessage);

            return false;
        }

        // 验证是否在此店铺添加该会员
        $result = $this->storeMemberLevelLogic->parseMemberLevel($orderData, 'store_id');

        // 不需要添加
        if (0 === count($result)) {
            return true;
        }

        // 要添加的会员
        $sataus = $this->storeMemberLogic->parseMember($result);

        if (!$sataus) {
            Log::error('店铺增加会员-- -- 处理失败');

            return false;
        }

        session()->remove('pay_config_by_user');

        // 清空当前用户全部与订单相关的session
        SessionManager::REMOVE_ALL();
        return true;
    }
}