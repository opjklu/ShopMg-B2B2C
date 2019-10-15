<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderPackage;
use App\Common\TraitClass\IsPayedTrait;
use App\Common\TraitClass\OrderAndPackageTrait;
use App\Models\Entity\DbOrderPackage;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;
use Tool\ParamsParse;
use Tool\SessionManager;

/**
 * 逻辑处理层
 * @Bean()
 */
class OrderPackageLogic extends AbstractLogic
{

    use IsPayedTrait;

    use OrderAndPackageTrait;


    public function __construct()
    {
        $this->tableName = DbOrderPackage::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        return [
            'address_id' => [
                'number' => '地址必须是数字'
            ]
        ];
    }

    /**
     * 获取结果
     */
    public function getResult()
    {
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return OrderPackage::class;
    }

    /**
     * @param array $post
     * @return array
     */
    protected function getParseResultByAddAll(array $post): array
    {
        return array_values($post);
    }

    /**
     * 添加套餐订单
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getAddOrderData(array $post): array
    {
        $dataArray = SessionManager::GET_GOODS_DATA_SOURCE();

        $args = $post['goods'];

        $invoice = $post['invoice_id'];

        // 准备生成订单
        $orderData = [];

        $time = time();

        $ownMyConpon = SessionManager::GET_OWN_MY_COUPON();

        $freightMoney = SessionManager::GET_FREIGHT_MONEY();

        $userId = session()->get('user_id');

        foreach ($dataArray as $key => $value) {

            $orderData[$value['store_id']][OrderPackage::$addressId] = $post['address_id'];

            $orderData[$value['store_id']][OrderPackage::$orderSn_id] = Tool::toGUID();

            $orderData[$value['store_id']][OrderPackage::$createTime] = $time;

            $orderData[$value['store_id']][OrderPackage::$userId] = $userId;

            $orderData[$value['store_id']][OrderPackage::$orderStatus] = 0;

            $orderData[$value['store_id']][OrderPackage::$platform] = 2;

            $orderData[$value['store_id']][OrderPackage::$priceSum] += $value['price_sum'];

            $orderData[$value['store_id']][OrderPackage::$translate] = isset($invoice[$value['store_id']]['translate']) ? $invoice[$value['store_id']]['translate'] : 0;

            $orderData[$value['store_id']][OrderPackage::$storeId] = $value['store_id'];

            $orderData[$value['store_id']][OrderPackage::$status] = 0;

            $orderData[$value['store_id']][OrderPackage::$platform] = 0;

            $orderData[$value['store_id']][OrderPackage::$couponDeductible] = isset($ownMyConpon[$value['store_id']]) ? $ownMyConpon[$value['store_id']] : 0;

            $orderData[$value['store_id']][OrderPackage::$shippingMonery] = $freightMoney[$value['store_id']];

            if (!empty($args[$value['store_id']])) {
                $orderData[$value['store_id']][OrderPackage::$remarks] = $args[$value['store_id']];
            }
        }
        return $orderData;
    }

    /**
     * 产生订单--立即购买
     * @param array $data
     * @return array
     */
    public function orderBegin(array $data)
    {
        $freightMoney = SessionManager::GET_FREIGHT_MONEY();

        if (empty($freightMoney)) {
            $this->errorMessage = '运费错误';
            return [];
        }

        $goods = SessionManager::GET_GOODS_DATA_SOURCE();

        if (empty($goods)) {
            $this->errorMessage = '商品错误';
            return [];
        }

        $orderData = $this->getAddOrderData($data);

        Db::beginTransaction();

        $insertId = $this->addAll($orderData);

        if (!$this->traceStation($insertId)) {
            $this->errorMessage .= '生成套餐订单失败';
            return [];
        }

        $invoice = $data['invoice_id'];

        $userBuyStore = array_keys($orderData);

        $orderDataNumber = count($orderData);

        $number = array();

        $payData = [];

        $ownMyCoupon = SessionManager::GET_OWN_MY_COUPON();

        $goodsMoney = SessionManager::GET_COUPON_MONEY();

        $invoiceData = [];

        for ($i = 0; $i < $orderDataNumber; $i++) {
            $number[$userBuyStore[$i]] = [];

            $orderId = $i + $insertId;

            $number[$userBuyStore[$i]]['order_id'] = $orderId;

            $number[$userBuyStore[$i]]['store_id'] = $userBuyStore[$i];

            $couponMoney = isset($ownMyCoupon[$value['store_id']]) ? $ownMyCoupon[$userBuyStore[$i]] : 0;

            $payData[$orderId] = [];

            $payData[$orderId]['order_id'] = $orderId;

            $payData[$orderId]['store_id'] = $userBuyStore[$i];

            $payData[$orderId]['total_money'] = sprintf("%.2f", $goodsMoney[$userBuyStore[$i]] + $freightMoney[$userBuyStore[$i]] - $couponMoney);

            if (!empty($invoice[$userBuyStore[$i]]['id'])) {

                $invoiceData[$i] = [];

                $invoiceData[$i]['id'] = $invoice[$userBuyStore[$i]]['id'];

                $invoiceData[$i]['order_id'] = $orderId;

                $i++;
            }
        }

        return [
            $payData,
            $invoiceData,
            $number
        ];
    }

    /**
     * 支付回调成功后 修改订单状态
     */
    public function paySuccessEditStatus(array $orderId, array $payConfig): bool
    {

       Db::beginTransaction();

        $status = $this->getQueryBuilderProxy()
            ->whereIn(OrderPackage::$id, $orderId)
            ->save([
                OrderPackage::$payTime => time(),
                OrderPackage::$orderStatus => '1',
                OrderPackage::$payType => $payConfig['pay_type_id'],
                OrderPackage::$platform => $payConfig['type']
            ]);

        return $this->traceStation($status);
    }

    // 获取订单状态
    public function getOrderStatus(array $data)
    {
        return $this->getQueryBuilderProxy()
            ->whereIn(OrderPackage::$id, $data)
            ->field([OrderPackage::$id, OrderPackage::$orderStatus])
            ->getField();
    }

    // 删除订单
    public function orderDel(array $data): int
    {
        return $this->getQueryBuilderProxy()
            ->where('id', $data['id'])
            ->where('user_id', session()->get('user_id'))
            ->save(['status' => $data['status']]);

    }

    // 订单再次购买
    public function getBuyAgain()
    {
    }

    /**
     * 提交事务
     *
     * @return bool
     */
    public function submitTranstion(): void
    {
        Db::commit();
    }

    /**
     * 处理条件
     *
     * @return array
     */
    protected function parseOption(array $options): array
    {
        $options['where']['user_id'] = session()->get('user_id');

        return $options;
    }

    /**
     * 获取待付款订单
     *
     * @return array
     */
    public function getPendingPaymentOrderList(array $post): array
    {
        return $this->getParseDataByList($post, [
            OrderPackage::$orderStatus => 0,
            OrderPackage::$status => 0
        ]);
    }

    /**
     * 获取全部列表（删除除外）
     *
     * @return array
     */
    public function geListAllIgnoreDel(array $post): array
    {
        return $this->getParseDataByList($post, [
            OrderPackage::$status => 0
        ]);
    }

    /**
     * 获取待发货订单
     */
    public function getPendingDelivery(array $post): array
    {
        return $this->getParseDataByList($post, [
            OrderPackage::$orderStatus => 1,
            OrderPackage::$status => 0
        ]);
    }

    /**
     * 获取待收货订单
     */
    public function getGoodsToBeReceived(array $post): array
    {
        return $this->getParseDataByList($post, [
            OrderPackage::$orderStatus => 3,
            OrderPackage::$status => 0
        ]);
    }

    /**
     * 获取待评价订单
     */
    public function getToBeEvaluated(array $post): array
    {
        return $this->getParseDataByList($post, [
            OrderPackage::$orderStatus => 4,
            OrderPackage::$status => 0,
            OrderPackage::$commentStatus => 0
        ]);
    }

    /**
     * 获取已评价评价订单
     */
    public function getAlreadyEvaluated(array $post): array
    {
        return $this->getParseDataByList($post, [
            OrderPackage::$orderStatus => 4,
            OrderPackage::$status => 0,
            OrderPackage::$commentStatus => 1
        ]);
    }

    /**
     * 获取已取消订单
     */
    public function getHaveBeenCancelled(array $post): array
    {
        return $this->getParseDataByList($post, [
            OrderPackage::$orderStatus => -1,
            OrderPackage::$status => 0
        ]);
    }

    // 获取我的订单
    public function getOrder(array $post): array
    {
        $timeWhere = $this->getIntermediateQuery($post);

        $rest = $this->getParseDataByList($post, $timeWhere);

        return $rest;
    }

    /**
     * 获取完成订单
     */
    public function getCompleted(array $post): array
    {
        return $this->getParseDataByList($post, [
            OrderPackage::$orderStatus => 4,
            OrderPackage::$status => 0
        ]);
    }

    /**
     * 获取订单根据id
     */
    public function getOrderDetail(array $post): array
    {
        $field = $this->getTableColum();

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where(OrderPackage::$id, $post['id'])
            ->where('user_id', session()->get('user_id'))
            ->find();
    }

    public function getSplitKeyByAddress(): string
    {
        return OrderPackage::$addressId;
    }

    public function getSplitKeyByPayType(): string
    {
        return OrderPackage::$payType;
    }

    public function getSplitKeyByExp(): string
    {
        return OrderPackage::$expId;
    }

    public function getSplitKeyByStore(): string
    {
        return OrderPackage::$storeId;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    protected function likeSerachArray(): array
    {
        return [
            OrderPackage::$orderSn_id
        ];
    }

    /**
     * 获取具体搜索字段（非模糊）
     *
     * @return
     *
     */
    protected function searchArray(): array
    {
        return [
            OrderPackage::$orderStatus,
            OrderPackage::$commentStatus,
            OrderPackage::$payTime
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getSearchOrderKey()
     */
    public function getSearchOrderKey(): array
    {
        return [
            OrderPackage::$createTime => 'DESC',
            OrderPackage::$overTime => 'DESC',
            OrderPackage::$deliveryTime => 'DESC'
        ];
    }

    /**
     * 评论状态
     *
     * @return bool
     */
    public function commentStatus(array $data): bool
    {
        $status = $this->getQueryBuilderProxy()
            ->where(OrderPackage::$id, $data['order_id'])
            ->where(OrderPackage::$userId, session()->get('user_id'))
            ->save([
                OrderPackage::$commentStatus => 1
            ]);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '评论失败（修改状态）';

            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 已签收
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $data = [];

        $data[OrderPackage::$overTime] = time();

        $data[OrderPackage::$orderStatus] = 4;

        $data[OrderPackage::$id] = $update['id'];

        return $data;
    }

    /**
     * 已签收
     *
     * {@inheritdoc}
     *
     */
    public function getOverTime(array $post): bool
    {
        Db::beginTransaction();

        if (!$this->traceStation($this->saveData($post))) {
            $this->errorMessage = '签收失败';
            return false;
        }
        return true;
    }

    /**
     * 确认收货
     *
     * @param array $post
     * @return bool
     * @author 米糕网络团队
     */
    public function confirmGetgoods(array $post): bool
    {
        Db::beginTransaction();

        $status = $this->getQueryBuilderProxy()
            ->where(OrderPackage::$id, $post[OrderPackage::$id])
            ->where(OrderPackage::$orderStatus, 3)
            ->where(OrderPackage::$userId, session()->get('user_id'))
            ->save([
                OrderPackage::$orderStatus => 4
            ]);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '确认收货失败';
            return false;
        }
        return true;
    }

    /**
     * 获取套餐订单数据
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getOrderSnByData(array $data, string $splitKey): array
    {
        $field = [
            OrderPackage::$id,
            OrderPackage::$orderSn_id,
            OrderPackage::$priceSum
        ];

        $paramEntity = new ParamsParse($data, $field, OrderPackage::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }

    /**
     * @return array
     */
    protected function getWhereBySaveAndDelete(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }
}
