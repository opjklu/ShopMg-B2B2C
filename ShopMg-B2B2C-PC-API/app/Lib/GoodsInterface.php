<?php
declare(strict_types=1);

namespace App\Lib;

use Swoft\Core\ResultInterface;

/**
 * 商品服务
 *
 * @author Administrator
 * @method ResultInterface deferGetAllGoods(int $page)
 * @method ResultInterface deferGoodsById(string $id)
 * @method ResultInterface deferGetGoodInfo(string $id)
 */
interface GoodsInterface
{

    /**
     * 获取全部商品
     *
     * @return array
     */
    public function getAllGoods(int $page): array;

    /**
     * 获取一个商品
     *
     * @return array
     */
    public function getGoodsById(string $id): array;

    public function count(): int;

    /**
     * 获取商品详情
     *
     * @return array
     */
    public function getGoodInfo(string $id): array;
}