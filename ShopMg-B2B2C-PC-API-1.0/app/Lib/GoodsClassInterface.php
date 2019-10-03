<?php
declare(strict_types=1);

namespace App\Lib;

use Swoft\Core\ResultInterface;

/**
 * 商品服务
 *
 * @author Administrator
 * @method ResultInterface deferGoodsClassByCondition(string $id)
 */
interface GoodsClassInterface
{

    /**
     * 获取一个商品
     *
     * @return array
     */
    public function getGoodsClassByCondition(array $id): array;
}