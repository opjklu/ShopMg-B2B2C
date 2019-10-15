<?php
declare(strict_types=1);

namespace App\Lib;

use Symfony\Contracts\Service\ResetInterface;

/**
 * 图片服务
 *
 * @author Administrator
 * @method ResetInterface deferGetGoodsImageById(string $goodsId)
 */
interface GoodsImagesInterface
{

    /**
     * 根据商品编号获取图片
     * @param string $goodsId
     * @return array
     */
    public function getGoodsImageById(string $goodsId): array;
}