<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsRestrictions;
use App\Models\Entity\DbGoodsRestrictions;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class GoodsRestrictionsLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbGoodsRestrictions::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'id' => [
                'required' => '必须输入ID'
            ]
        ];
        return $message;
    }

    /**
     * 得到所有 的抢购商品包括首页广告图 商品图片 商品标题 活动抢购状态 抢购价格 原价 购买人数 设置提醒人数
     */
    public function getAllRestrictGoods()
    {
        $data = $this->getQueryBuilderProxy()->getShopsInfo();
        if (empty($data)) {
            return false;
        }
        return $data;
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
        return GoodsRestrictions::class;
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
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
        return [];
    }
}
