<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderReturnGoods;
use App\Models\Entity\DbOrderReturnGoods;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 退货
 *
 * @Bean()
 */
class OrderReturnGoodsLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbOrderReturnGoods::class;
    }

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
        return OrderReturnGoods::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByReturn()
    {
        $message = [
            'goods_id' => [
                'number' => '必须输入商品id'
            ],
            'order_id' => [
                'number' => '必须输入订单id'
            ],
            'tuihuo_case' => [
                'number' => '退货理由必须填'
            ],
            'create_time' => [
                'number' => '申请退货时间'
            ],
            'explain' => [
                'number' => '退货说明'
            ]

        ];
        return $message;
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
     *
     * @name 退货--退货列表
     *
     */
    public function getOrderReturnList(array $post)
    {
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
            'order_id',
            'id',
            'tuihuo_case',
            'store_id',
            'create_time',
            'goods_id',
            'explain',
            'status',
            'price',
            'is_receive'
        ];
    }

    /**
     *
     * @name 退货--退货详情
     */
    public function getOrderReturnDetails(array $post)
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where('user_id', session()->get('user_id'))
            ->where('id', $post['id'])
            ->find();
    }

    /**
     * 获取订单关联key
     *
     * @return string
     */
    public function getSplitKeyByOrderId(): string
    {
        return OrderReturnGoods::$orderId;
    }

    /**
     * 获取订单关联key
     *
     * @return string
     */
    public function getSplitKeyByGoodsId(): string
    {
        return OrderReturnGoods::$goodsId;
    }

    /**
     * 获取店铺关联key
     *
     * @return string
     */
    public function getSplitKeyByStoresId(): string
    {
        return OrderReturnGoods::$storeId;
    }
}
