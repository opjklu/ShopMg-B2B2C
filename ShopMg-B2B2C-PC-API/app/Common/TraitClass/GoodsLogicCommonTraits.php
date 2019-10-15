<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

use App\Common\FieldMapping\Goods;

/**
 * 商品逻辑公共部分
 *
 * @author Administrator
 *
 */
trait GoodsLogicCommonTraits
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \Common\Logic\AbstractGetDataLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            Goods::$id,
            Goods::$pId,
            Goods::$priceMarket,
            Goods::$priceMember,
            Goods::$stock,
            Goods::$classId,
            Goods::$classThree,
            Goods::$classTwo,
            Goods::$title,
            Goods::$expressId,
            Goods::$weight,
            Goods::$brandId,
            Goods::$storeId
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Common\Logic\AbstractGetDataLogic::likeSerachArray()
     */
    protected function likeSerachArray(): array
    {
        return [
            Goods::$title
        ];
    }

    /**
     *
     * @return string
     */
    public function getSplitKeyByPid(): string
    {
        return Goods::$pId;
    }
}