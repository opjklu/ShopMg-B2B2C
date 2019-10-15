<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderPackageReturnGoods;
use App\Common\TraitClass\ExchangeOfGoodsTrait;
use App\Models\Entity\DbOrderPackageReturnGoods;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 * 逻辑处理层
 * @Bean()
 */
class OrderPackageReturnGoodsLogic extends AbstractLogic
{
    use ExchangeOfGoodsTrait;


    public function __construct()
    {
        $this->tableName = DbOrderPackageReturnGoods::class;
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
        return OrderPackageReturnGoods::class;
    }

    // 填写快递单号
    public function setCourierNumber(array $post): bool
    {
        Db::beginTransaction();

        $status = $this->saveData($post);

        if (!$this->traceStation($status)) {
            return false;
        }

        return true;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \App\Models\Logic\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $update['update_time'] = time();
        
        return $update;
    }

    // 申请售后进度查询
    public function getProgressQuery()
    {
        $where['user_id'] = session()->get('user_id');
        $field = "id,goods_id,status,create_time,number";
        $return = $this->getQueryBuilderProxy()
            ->field($field)
            ->where($where)
            ->order("create_time DESC")
            ->select();
        if (empty($return)) {
            return array(
                "status" => 0,
                "message" => "暂无数据!",
                "data" => ""
            );
        }
        $goods = $this->goodsModel->getTitleByTwo($return);
        return array(
            "status" => 1,
            "message" => "获取成功!",
            "data" => $goods
        );
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
            'goods_id',
            'status',
            'create_time',
            'number',
            'price',
            'order_id'
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
     * 搜索
     *
     * @param array $data
     * @return array
     */
    public function getSearchOrder(array $post, array $data): array
    {
        return $this->getParseDataByList($post, [
            [
                'order_id',
                'in',
                $data
            ]
        ]);
    }

    /**
     * 获取订单关联key
     *
     * @return string
     */
    public function getSplitKeyByOrderId(): string
    {
        return OrderPackageReturnGoods::$orderId;
    }

    /**
     * 获取订单关联key
     *
     * @return string
     */
    public function getSplitKeyByGoodsId(): string
    {
        return OrderPackageReturnGoods::$goodsId;
    }

    /**
     * 获取店铺关联key
     *
     * @return string
     */
    public function getSplitKeyByStoresId(): string
    {
        return OrderPackageReturnGoods::$storeId;
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
}
