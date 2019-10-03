<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsCompare;
use App\Models\Entity\DbGoodsCompare;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 *
 * @author wq
 *
 * @Bean()
 */
class GoodsCompareLogic extends AbstractLogic
{

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->tableName = DbGoodsCompare::class;
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
        return GoodsCompare::class;
    }

    /**
     * 返回验证数据
     */
    public function getMessageNotice()
    {
        $message = [
            'brand_id' => [
                'number' => '必须是数字'
            ],
            'title' => [
                'required' => '必须传入商铺ID'
            ],
            'price_market' => [
                'number' => '商品价格必须是数字'
            ]

        ];
        return $message;
    }

    /**
     * 商品对比
     */
    public function compareGoods()
    {
        $goods_id = $_POST['goods_id'];
        $res = $this->getQueryBuilderProxy()->getgoods_info($goods_id);
        return $res;
    }
}

?>