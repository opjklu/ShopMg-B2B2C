<?php

namespace App\Models\Logic\Specific;

use App\Models\Entity\DbComplain;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class ComplainLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbComplain::class;
    }


    /**
     * 获取结果
     */
    public function getResult()
    {
    }

    /**
     * 获取 商品相关字段
     */
    public function getSplitKeyByGoods()
    {
        return Collection::$goodsId;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return Collection::class;
    }



    protected function getParseResultByAdd(array $insert): array
    {
        $insert['complain_datetime'] = time(); // 投诉时间

        $insert['user_id'] = session()->get('user_id');

        return $insert;
    }

    protected function getTableColum(): array
    {
       return [
           'id','order_goods_id','accused_id','complain_datetime','order_id','complain_state'
       ];
    }

    /**
     * @return string
     */
    public function getSplitKeyByOrderId(): string
    {
        return 'order_id';
    }

    /**
     * @return string
     */
    public function getSplitKeyByStoreId(): string
    {
        return 'store_id';
    }

    /**
     * 处理条件
     *
     * @param array $options
     * @return array
     */
    protected function parseOption(array $options): array
    {
        $options['where']['user_id'] = session()->get('user_id');

        return $options;
    }

    /**
     * 保存时条件处理
     *
     * @param array $post
     * @return array
     */
    protected function getWhereBySaveAndDelete(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }
}
