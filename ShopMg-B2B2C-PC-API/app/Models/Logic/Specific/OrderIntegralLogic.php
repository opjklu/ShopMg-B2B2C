<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderIntegral;
use App\Common\TraitClass\IsPayedTrait;
use App\Models\Entity\DbOrderIntegral;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;
use Tool\Token;
use Tool\SessionManager;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class OrderIntegralLogic extends AbstractLogic
{
    use IsPayedTrait;

    /**
     * 积分订单
     *
     * @var integer
     */
    private $orderIntegralInsertId = 0;

    /**
     *
     * @return number
     */
    public function getOrderIntegralInsertId()
    {
        return $this->orderIntegralInsertId;
    }

    /**
     * 支付数据
     *
     * @var array
     */
    private $payData = [];

    /**
     *
     * @return array
     */
    public function getPayData(): array
    {
        return $this->payData;
    }


    public function __construct()
    {
        $this->tableName = DbOrderIntegral::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByBuildOrder(): array
    {
        return [
            'remarks' => [
                'specialCharFilter' => '积分备注'
            ],
            'address_id' => [
                'number' => '必须输入收货地址'
            ]
        ];
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        return [
            'integral' => [
                'required' => '必须输入本次使用积分'
            ],
            'goods_id' => [
                'required' => '必须输入商品ID'
            ],
            'address_id' => [
                'required' => '请选择收货地址'
            ],
            'platform' => [
                'required' => '请写明下单平台'
            ],
            'store_id' => [
                'required' => '请标明商品所属店铺ID'
            ]
        ];
    }

    /**
     * 积分兑换-立即兑换 参数验证
     */
    public function getValidateByOrder()
    {
        return [
            'orderId' => [
                'required' => '订单ID必填',
                'number' => '订单ID必须是数字'
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
        return OrderIntegral::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [
        ];
    }

    /**
     * 积分兑换处理
     */
    public function commitConfirm(): array
    {
        // 验证是否会出现异常
        $freight = SessionManager::GET_FREIGHT_MONEY();

        $goods = SessionManager::GET_GOODS_DATA_SOURCE();

        Db::beginTransaction();

        $insertId = $this->addData();

        if (!$this->traceStation($insertId)) {
            return [];
        }

        $totalMoney = $goods['price_sum'] + $freight[$goods['store_id']];

        $payData = [];

        $payData[0] = [
            'order_id' => $insertId,
            'store_id' => $goods['store_id'],
            'integral' => $goods['integral'],
            'total_money' => sprintf("%.2f", $totalMoney),
            'order_id' => $insertId
        ];
        return $payData;
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

        $freightMoney = SessionManager::GET_FREIGHT_MONEY();

        $time = time();

        // 积分兑换 生成订单
        $orderSn = Token::toGUID();

        $orderData = [];

        $orderData[OrderIntegral::$orderSn] = $orderSn;
        // 总积分
        $orderData[OrderIntegral::$interaglTotal] = $goods['integral'];
        $orderData[OrderIntegral::$addressId] = $insert['address_id'];
        $orderData[OrderIntegral::$userId] = session()->get('user_id');
        $orderData[OrderIntegral::$createTime] = $time;
        $orderData[OrderIntegral::$payTime] = 0;
        $orderData[OrderIntegral::$overTime] = 0;
        $orderData[OrderIntegral::$orderStatus] = 0;
        $orderData[OrderIntegral::$commentStatus] = 0;
        $orderData[OrderIntegral::$payType] = 0;
        $orderData[OrderIntegral::$remarks] = isset($insert['remarks']) ? $insert['remarks'] : '';
        $orderData[OrderIntegral::$status] = 0;
        $orderData[OrderIntegral::$translate] = 0;
        $orderData[OrderIntegral::$platform] = 2;
        $orderData[OrderIntegral::$orderType] = 0;
        $orderData[OrderIntegral::$storeId] = $goods['store_id'];
        $orderData[OrderIntegral::$priceSum] = $goods['price_sum'];

        $orderData[OrderIntegral::$shippingMonery] = $freightMoney[$goods['store_id']];

        return $orderData;
    }

    /**
     * 支付回调成功后 修改订单状态
     */
    public function paySuccessEditStatus(array $orderId, array $payConfig)
    {

       Db::beginTransaction();

        $status = $this->getQueryBuilderProxy()
            ->whereIn(OrderIntegral::$id, $orderId)
            ->save([
                OrderIntegral::$payTime => time(),
                OrderIntegral::$orderStatus => 1,
                OrderIntegral::$payType => $payConfig['pay_type_id'],
                OrderIntegral::$platform => $payConfig['type']
            ]);

        if (!$this->traceStation($status)) {
            return false;
        }

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::parseOption()
     */
    protected function parseOption(array $options): array
    {
        $options['where']['user_id'] = session()->get('user_id');

        return $options;
    }

    /**
     * 取消订单
     *
     * @return bool
     */
    public function cancelOrder(array $post): int
    {
        return $this->getQueryBuilderProxy()
            ->where(OrderIntegral::$id, $post['id'])
            ->where('user_id', session()->get('user_id'))
            ->save([
                OrderIntegral::$orderStatus => -1,
            ]);
    }

    /**
     * 已收货
     *
     * @return bool
     */
    public function confirmGetgoods(array $post): int
    {
        return $this->getQueryBuilderProxy()
        ->where(OrderIntegral::$id, $post['id'])
        ->where('user_id', session()->get('user_id'))
        ->save([
            OrderIntegral::$orderStatus => 4,
        ]);
    }
    /**
     * 删除订单
     *
     * @return bool
     */
    public function delOrder(array $post): int
    {
        return $this->getQueryBuilderProxy()
            ->where(OrderIntegral::$id, $post['id'])
            ->where('user_id', session()->get('user_id'))
            ->save([
                OrderIntegral::$status => 1
            ]);
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
            OrderIntegral::$id,
            OrderIntegral::$addressId,
            OrderIntegral::$createTime,
            OrderIntegral::$deliveryTime,
            OrderIntegral::$expressId,
            OrderIntegral::$expId,
            OrderIntegral::$interaglTotal,
            OrderIntegral::$orderSn,
            OrderIntegral::$orderStatus,
            OrderIntegral::$priceSum,
            OrderIntegral::$shippingMonery,
            OrderIntegral::$remarks,
            OrderIntegral::$storeId,
            OrderIntegral::$payType,
            OrderIntegral::$storeId,
            OrderIntegral::$payTime
        ];
    }

    /**
     * 根据订单编号获取订单信息
     *
     * @return array
     */
    public function getOrderDetail(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(OrderIntegral::$id, $post['id'])
            ->find();
    }

    /**
     * 地址关联key
     *
     * @return string
     */
    public function getSplitKeyByAddress(): string
    {
        return OrderIntegral::$addressId;
    }

    /**
     * 支付类型关联key
     *
     * @return string
     */
    public function getSplitKeyByPayType(): string
    {
        return OrderIntegral::$payType;
    }

    /**
     * 快递关联key
     *
     * @return string
     */
    public function getSplitKeyByExp(): string
    {
        return OrderIntegral::$expId;
    }

    /**
     * 快递关联key
     *
     * @return string
     */
    public function getSplitKeyByStore(): string
    {
        return OrderIntegral::$storeId;
    }

    /**
     * 组装支付数据
     *
     * @return array
     */
    public function orderPayBuildData(array $post): bool
    {
        $field = [
            OrderIntegral::$priceSum,
            OrderIntegral::$shippingMonery,
            OrderIntegral::$interaglTotal,
            OrderIntegral::$storeId,
            OrderIntegral::$id
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(OrderIntegral::$id, $post['id'])
            ->where( OrderIntegral::$userId, session()->get('user_id'))
            ->find();
        if (empty($data)) {
            $this->errorMessage = '积分订单错误';
            return false;
        }

        $totalMoney = $data[OrderIntegral::$priceSum] + $data[OrderIntegral::$shippingMonery];

        if ($totalMoney <= 0) {
            $this->errorMessage = '订单金额错误';
            return false;
        }

        $payData = [];

        $payData[0] = [
            'order_id' => $data[OrderIntegral::$id],
            'store_id' => $data[OrderIntegral::$storeId],
            'integral' => $data[OrderIntegral::$interaglTotal],
            'total_money' => sprintf('%.2f', $totalMoney)
        ];

        SessionManager::SET_ORDER_DATA($payData);

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

        $data[OrderIntegral::$overTime] = time();

        $data[OrderIntegral::$orderStatus] = 4;

        $data[OrderIntegral::$id] = $update['id'];

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

    // 获取我的订单
    public function getOrder(array $post): array
    {
        $timeWhere = $this->getIntermediateQuery($post);

        $rest = $this->getParseDataByList($post, $timeWhere);

        return $rest;
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
            OrderIntegral::$orderSn
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
            OrderIntegral::$createTime => 'DESC',
            OrderIntegral::$overTime => 'DESC',
            OrderIntegral::$deliveryTime => 'DESC'
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
            OrderIntegral::$payTime => [
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
            OrderIntegral::$orderStatus,
            OrderIntegral::$commentStatus,
            OrderIntegral::$payTime
        ];
    }
}
