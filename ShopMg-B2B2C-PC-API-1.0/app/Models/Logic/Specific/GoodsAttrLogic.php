<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsAttr;
use App\Common\FieldMapping\User;
use App\Models\Entity\DbGoodsAttr;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class GoodsAttrLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbGoodsAttr::class;
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
        return GoodsAttr::class;
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

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
        return [
            User::$userName
        ];
    }

    public function getValidateByLogin()
    {
        return [
            'goods_id' => [
                'required' => '商品ID必传'
            ]
        ];
    }

    public function getGoodsAttrs()
    {
    }

    /**
     * 获取商品对比列表
     */
    public function goodsAttrList()
    {
    }
}
