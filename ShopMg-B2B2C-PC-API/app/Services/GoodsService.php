<?php
declare(strict_types=1);

namespace App\Services;

use App\Lib\GoodsInterface;
use App\Models\Entity\DbGoods;
use Swoft\Core\ResultInterface;
use Swoft\Db\Query;
use Swoft\Rpc\Server\Bean\Annotation\Service;

/**
 * 实现商品服务
 *
 * @author Administrator
 * @method ResultInterface deferGetAllGoods()
 * @method ResultInterface deferGoodsById(string $id)
 * @method ResultInterface deferGetGoodInfo(string $id)
 * @Service()
 */
class GoodsService implements GoodsInterface
{

    /**
     * 获取全部商品
     *
     * @return array
     */
    public function getAllGoods(int $page): array
    {
        $page = ($page - 1) * 15;

        $data = Query::table(DbGoods::class)->where('shelves', 1)
            ->where('approval_status', 1)
            ->limit(15, $page)
            ->get()
            ->getResult([
                'items'
            ]);

        return $data;
    }

    /**
     * 获取一个商品
     *
     * @return array
     */
    public function getGoodsById(string $id): array
    {
    }

    public function count(): int
    {
        return DbGoods::count('id', [
            'approval_status' => 1,
            'shelves' => 1
        ])->getResult();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Lib\GoodsInterface::getGoodInfo()
     */
    public function getGoodInfo(string $id): array
    {
        $field = [
            'id',
            'store_id',
            'title',
            'price_market',
            'price_member',
            'stock',
            'comment_member',
            'sales_sum',
            'p_id',
            'store_id'
        ];

        return Query::table(DbGoods::class)->where('id', $id)
            ->get($field)
            ->getResult([
                'items'
            ]);
    }
}