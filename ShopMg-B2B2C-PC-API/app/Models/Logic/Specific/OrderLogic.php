<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Order;
use App\Common\TraitClass\IsPayedTrait;
use App\Common\TraitClass\OrderAndPackageTrait;
use App\Models\Entity\DbOrder;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;
use Tool\OrderStatus;
use Tool\ParamsParse;
use Tool\SessionManager;
use Tool\Token;

/**
 * 逻辑处理层
 * @Bean()
 */
class OrderLogic extends AbstractLogic
{
    use IsPayedTrait;

    use OrderAndPackageTrait;


    public function __construct()
    {
        $this->tableName = DbOrder::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        return [
            'price_sum' => [
                'required' => '订单总价必填'
            ],
            'address_id' => [
                'required' => '收货地址必填'
            ],
            'freight_id' => [
                'required' => '运费Id必填'
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
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return Order::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [];
    }

    // 获取订单数量
    // -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功,
    public function getOrderStatusNum(): array
    {

        // 全部
        $all = $this->getOrderNum([
            'status' => 0
        ]);
        // 待付款
        $payment = $this->getOrderNum([
            'order_status' => 0,
            'status' => 0
        ]);
        // 待发货
        $delivery = $this->getOrderNum([
            'order_status' => 1,
            'status' => 0
        ]);
        // //待收货
        $received = $this->getOrderNum([
            'order_status' => 3,
            'status' => 0
        ]);

        // 待评价
        $evaluated = $this->getOrderNum([
            'order_status' => 4,
            'comment_status' => 0,
            'status' => 0
        ]);
        $data = [
            "all" => $all,
            "payment" => $payment,
            "delivery" => $delivery,
            "received" => $received,
            "evaluated" => $evaluated

        ];
        return $data;
    }

    public function getOrderNum(array $where): int
    {
        $userId = session()->get('user_id');

        $where['user_id'] = $userId;

        return $this->getQueryBuilderProxy()
            ->condition($where)
            ->count();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            'id',
            'order_sn_id',
            'order_status',
            'create_time',
            'comment_status',
            'store_id',
            'price_sum',
            'express_id',
            'exp_id',
            'user_id',
            'shipping_monery',
            'address_id'
        ];
    }

    // 获取我的订单
    public function getOrder(array $post): array
    {
        return $this->getParseDataByList($post, $this->getIntermediateQuery($post));
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
     * 待付款订单
     */
    public function getPendingPaymentOrder(array $post): array
    {
        $options = [
            'field' => $this->getTableColum(),
            'order' => $this->getOrderBySearch($post),
            'where' => [
                Order::$orderStatus => 0,
                Order::$status => 0
            ]
        ];

        return $this->getDataByPage($post, $options);
    }

    /**
     * 待发货 订单
     */
    public function getPendingDelivery(array $post): array
    {
        $options = [
            'field' => $this->getTableColum(),
            'order' => $this->getOrderBySearch($post),
            'where' => [
                Order::$orderStatus => 1,
                Order::$status => 0
            ]
        ];

        return $this->getDataByPage($post, $options);
    }

    /**
     * 待收货 订单
     */
    public function getGoodsToBeReceived(array $post): array
    {
        $options = [
            'field' => $this->getTableColum(),
            'order' => $this->getOrderBySearch($post),
            'where' => [
                Order::$orderStatus => 3,
                Order::$status => 0
            ]
        ];

        return $this->getDataByPage($post, $options);
    }

    /**
     * 待评价订单 订单
     */
    public function getToBeEvaluated(array $post): array
    {
        $options = [
            'field' => $this->getTableColum(),
            'order' => $this->getOrderBySearch($post),
            'where' => [
                Order::$orderStatus => 4,
                Order::$commentStatus => 0,
                Order::$status => 0
            ]
        ];

        return $this->getDataByPage($post, $options);
    }

    /**
     * 已评价评价订单 订单
     */
    public function getAlreadyBeEvaluated(array $post): array
    {
        $options = [
            'field' => $this->getTableColum(),
            'order' => $this->getOrderBySearch($post),
            'where' => [
                Order::$orderStatus => 4,
                Order::$commentStatus => 1,
                Order::$status => 0
            ]
        ];

        return $this->getDataByPage($post, $options);
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
            Order::$orderSn_id
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
            Order::$createTime => 'DESC',
            Order::$overTime => 'DESC',
            Order::$deliveryTime => 'DESC'
        ];
    }

    /**
     * 获取介于查询字段
     *
     * @return array
     */
    protected function getIntermediateQueryColumn(): array
    {
        return [
            Order::$payTime => [
                'start_time',
                'end_time'
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::searchArray()
     */
    protected function searchArray(): array
    {
        return [
            Order::$orderStatus,
            Order::$commentStatus,
            Order::$payTime
        ];
    }

    // 获取订单评价数量
    public function getOrderCommonNum()
    {
        $userId = session()->get('user_id');

        $where['user_id'] = $userId;
        $where['order_status'] = 4;
        $where['comment_status'] = 0;
        $where['status'] = 0;
        $already = $this->getQueryBuilderProxy()
            ->condition($where)
            ->count();
        $s_where['user_id'] = $userId;
        $s_where['order_status'] = 4;
        $s_where['comment_status'] = 1;
        $s_where['status'] = 0;
        $stay = $this->getQueryBuilderProxy()
            ->condition($s_where)
            ->count();
        $data['already'] = $already;
        $data['stay'] = $stay;
        return array(
            'status' => 1,
            'message' => '获取成功',
            'data' => $data
        );
    }


    // 订单列表取消订单
    public function getCancelOrderByList(array $post): bool
    {
        Db::beginTransaction();

        $status = $this->getQueryBuilderProxy()
            ->condition([
                'id' => $post['id'],
                'user_id' => session()->get('user_id')
            ])
            ->save([
                'order_status' => -1
            ]);

        return $this->traceStation($status);
    }

    // 订单详情
    public function getOrderDetail(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where('id', $post['id'])
            ->where('user_id', session()->get('user_id'))
            ->find();
    }

    /**
     * 多商品生成订单
     * @param array $data
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public function multiCommodityGeneratedOrder(array $data): array
    {
        $freightMoney = SessionManager::GET_FREIGHT_MONEY();

        if (empty($freightMoney)) {
            $this->errorMessage = '运费错误';
            return [];
        }

        $orderData = $this->getAddOrderData($data);

        // 获取购物车商品信息
        Db::beginTransaction();

        $insertId = $this->addAll($orderData);

        if (!$this->traceStation($insertId)) {
            $this->errorMessage .= '、由于长时间没有购买，缓存时间过期，请刷新重新购买。生成订单失败';
            return [];
        }

        $invoice = $data['invoice_id'];

        $number = array();

        $payData = [];

        $ownMyCoupon = SessionManager::GET_COUPON_LIST();

        $goodsMoney = SessionManager::GET_COUPON_MONEY();

        $userBuyStore = array_keys($orderData);

        $j = 0;

        $orderDataNumber = count($orderData);

        $invoiceData = [];

        for ($i = 0; $i < $orderDataNumber; $i++) {
            $number[$userBuyStore[$i]] = [];

            $orderId = $i + $insertId;

            $number[$userBuyStore[$i]]['order_id'] = $orderId;

            $number[$userBuyStore[$i]]['store_id'] = $userBuyStore[$i];

            $couponMoney = isset($ownMyCoupon[$userBuyStore[$i]]['money']) ? $ownMyCoupon[$userBuyStore[$i]]['money'] : 0;

            $payData[$i] = [];

            $payData[$i]['order_id'] = $orderId;

            $payData[$i]['store_id'] = $userBuyStore[$i];

            $payData[$i]['total_money'] = sprintf("%.2f", $goodsMoney[$userBuyStore[$i]] + $freightMoney[$userBuyStore[$i]] - $couponMoney);

            if (!empty($invoice[$userBuyStore[$i]]['id'])) {

                $invoiceData[$j] = [];

                $invoiceData[$j]['id'] = $invoice[$userBuyStore[$i]]['id'];

                $invoiceData[$j]['order_id'] = $orderId;

                $j++;
            }
        }

        return [
            $payData,
            $invoiceData,
            $number
        ];
    }

    /**
     * 立即购买->下单
     * @param array $params
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public function placeTheOrder(array $params): array
    {
        $freightMoney = SessionManager::GET_FREIGHT_MONEY();

        if (0 === count($freightMoney)) {
            $this->errorMessage = '运费错误';
            return [];
        }

        $goods = SessionManager::GET_GOODS_DATA_SOURCE();

        if (0 === count($goods)) {
            $this->errorMessage = '商品错误';
            return [];
        }
        // 获取购物车商品信息

        Db::beginTransaction();

        $insertId = $this->addData($params);

        if (!$this->traceStation($insertId)) {
            $this->errorMessage .= '、生成订单失败';
            return [];
        }

        $invoice = $params['invoice_id'];

        $invoiceData = [];

        if (!empty($invoice[$goods['store_id']]['id'])) {

            $invoiceData['id'] = $invoice[$goods['store_id']]['id'];

            $invoiceData['order_id'] = $insertId;
        }

        $ownMyCoupon = SessionManager::GET_OWN_MY_COUPON();

        $couponMoney = isset($ownMyCoupon[$goods['store_id']]) ? $ownMyCoupon[$goods['store_id']] : 0;

        $goodsMoney = SessionManager::GET_COUPON_MONEY();

        $totalMoney = $goodsMoney[$goods['store_id']] + $freightMoney[$goods['store_id']] - $couponMoney;

        return [
            [
                'order_id' => $insertId,
                'store_id' => $goods['store_id'],
                'total_money' => sprintf("%.2f", $totalMoney)
            ],
            $invoiceData,
            $insertId
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $goods = SessionManager::GET_GOODS_DATA_SOURCE();

        $ownMyConpon = SessionManager::GET_COUPON_LIST();

        $freightMoney = SessionManager::GET_FREIGHT_MONEY();

        $invoice = $insert['invoice_id'];

        $orderData = [];

        $orderData[Order::$orderSn_id] = Token::toGUID();

        $orderData[Order::$createTime] = time();

        $orderData[Order::$userId] = session()->get('user_id');

        $orderData[Order::$orderStatus] = 0;

        $orderData[Order::$addressId] = $insert['address_id'];

        $orderData[Order::$platform] = 0;

        $orderData[Order::$priceSum] = $goods['price_sum'];

        $orderData[Order::$translate] = $invoice[$goods['store_id']]['translate'];

        $orderData[Order::$storeId] = $goods['store_id'];

        $orderData[Order::$status] = 0;

        $orderData[Order::$couponDeductible] = isset($ownMyConpon[$goods['store_id']]['money']) ? $ownMyConpon[$goods['store_id']]['money'] : 0;

        $orderData[Order::$shippingMonery] = $freightMoney[$goods['store_id']];

        $orderData[Order::$remarks] = isset($insert['remarks']) ? $insert['remarks'] : '';

        return $orderData;
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
     * 批量添加时处理
     *
     * @param array $post
     * @return array []
     */
    private function getAddOrderData(array $post): array
    {
        $cartInfo = SessionManager::GET_GOODS_DATA_SOURCE();

        if (empty($cartInfo)) {
            return [];
        }

        $args = $post['goods'];

        $invoice = $post['invoice_id'];

        // 准备生成订单
        $orderData = [];

        $time = time();

        $ownMyConpon = SessionManager::GET_COUPON_LIST();

        $freightMoney = SessionManager::GET_FREIGHT_MONEY();

        $userId = session()->get('user_id');

        $i = 0;
        foreach ($cartInfo as $key => $value) {

            if (!isset($orderData[$value['store_id']])) {

                $orderData[$value['store_id']] = [];

                if (!isset($orderData[$value['store_id']][Order::$priceSum])) {
                    $orderData[$value['store_id']][Order::$priceSum] = 0;
                }
            }

            $orderData[$value['store_id']][Order::$addressId] = $post['address_id'];

            $orderData[$value['store_id']][Order::$orderSn_id] = Token::toGUID();

            $orderData[$value['store_id']][Order::$createTime] = $time;

            $orderData[$value['store_id']][Order::$userId] = $userId;

            $orderData[$value['store_id']][Order::$orderStatus] = 0;

            $orderData[$value['store_id']][Order::$platform] = 0;

            $orderData[$value['store_id']][Order::$priceSum] += $value['price_sum'];
            $orderData[$value['store_id']][Order::$translate] = $invoice[$value['store_id']]['translate'];

            $orderData[$value['store_id']][Order::$storeId] = $value['store_id'];

            $orderData[$value['store_id']][Order::$status] = 0;

            $orderData[$value['store_id']][Order::$couponDeductible] = isset($ownMyConpon[$value['store_id']]['money']) ? $ownMyConpon[$value['store_id']]['money'] : 0;

            $orderData[$value['store_id']][Order::$shippingMonery] = $freightMoney[$value['store_id']];

            if (!empty($args[$value['store_id']])) {
                $orderData[$value['store_id']][Order::$remarks] = $args[$value['store_id']];
            }
        }

        return $orderData;
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
     * 立即购买验证参数
     *
     * @return array
     */
    public function getValidateByGoods(): array
    {
        return [
            'invoice_id' => [
                'required' => '发票信息不能为空'
            ],
            'address_id' => [
                'number' => '收货地址必填'
            ]
        ];
    }

    /**
     * 配件检查参数
     */
    public function getMessageValidateByParts(): array
    {
        return [
            'address_id' => [
                'number' => '地址编号必须是数字'
            ],
            'invoice_id' => [
                'required' => '发票必须填写'
            ]
        ];
    }

    /**
     * 支付回调成功后 修改订单状态
     */
    public function paySuccessEditStatus(array $orderId, array $payConfig): bool
    {
        Db::beginTransaction();

        $status = $this->getQueryBuilderProxy()
            ->whereIn(Order::$id, $orderId)
            ->save([
                Order::$payTime => time(),
                Order::$orderStatus => OrderStatus::YesPaid,
                Order::$payType => $payConfig['pay_type_id'],
                Order::$platform => $payConfig['type']
            ]);

        return $this->traceStation($status);
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

        $data[Order::$overTime] = time();

        $data[Order::$orderStatus] = 4;

        $data[Order::$id] = $update['id'];

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
     * 个人中心--删除订单
     */
    public function delOrders(array $post): bool
    {
        Db::beginTransaction();

        $status = $this->getQueryBuilderProxy()
            ->condition([
                [
                    'id',
                    '=',
                    $post['id']
                ],
                [
                    'order_status',
                    'between',
                    -1,
                    0
                ],
                [
                    'user_id',
                    '=',
                    session()->get('user_id')
                ]
            ])
            ->delete();

        return $this->traceStation($status);
    }

    public function getOrderSnByData(array $data, string $splitKey): array
    {
        $field = [
            Order::$id,
            Order::$orderSn_id,
            Order::$priceSum
        ];

        $paramEntity = new ParamsParse($data, $field, Order::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }

    /**
     * 评论状态
     *
     * @return bool
     */
    public function commentStatus(array $post): bool
    {
        $status = $this->getQueryBuilderProxy()
            ->where(Order::$id, $post['order_id'])
            ->where(Order::$userId, session()->get('user_id'))
            ->save([
                Order::$commentStatus => 1
            ]);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '评论失败（修改状态）';

            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 根据退货信息获取订单号及其邮费信息
     *
     * @return array
     */
    public function getOrderDetailByOrderReturnRetuernGoods(array $data, string $splitKey): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                'order_sn_id',
                'shipping_monery'
            ])
            ->where('id', $data[$splitKey])
            ->where('user_id', session()->get('user_id'))
            ->find();
    }

    /**
     * 确认收货
     *
     * @author 米糕网络团队
     */
    public function confirmGetgoods(array $post): bool
    {
        Db::beginTransaction();

        $status = $this->getQueryBuilderProxy()
            ->where(Order::$id, $post[Order::$id])
            ->where(Order::$userId, session()->get('user_id'))
            ->where(Order::$orderStatus, OrderStatus::AlreadyShipped)
            ->save([
                Order::$orderStatus => OrderStatus::ReceivedGoods
            ]);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '确认收货失败';
            return false;
        }
        return true;
    }

    /**
     * 店铺关联数据
     *
     * @return string
     */
    public function getSplitKeyByStore(): string
    {
        return Order::$storeId;
    }

    /**
     * 地址关联key
     *
     * @return string
     */
    public function getSplitKeyByAddress(): string
    {
        return Order::$addressId;
    }

    public function getSplitKeyByPayType(): string
    {
        return Order::$payType;
    }

    public function getSplitKeyByExp(): string
    {
        return Order::$expId;
    }
}
