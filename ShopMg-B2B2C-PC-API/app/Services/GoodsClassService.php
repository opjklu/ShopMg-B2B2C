<?php
declare(strict_types=1);

namespace App\Services;

use App\Lib\GoodsClassInterface;
use App\Models\Entity\DbGoodsClass;
use Swoft\Core\ResultInterface;
use Swoft\Db\Query;
use Swoft\Rpc\Server\Bean\Annotation\Service;

/**
 * 实现商品服务
 *
 * @author Administrator
 * @method ResultInterface deferGoodsClassByCondition(string $id)
 * @Service()
 */
class GoodsClassService implements GoodsClassInterface
{

    /**
     * 获取一个商品
     *
     * @return array
     */
    public function getGoodsClassByCondition(array $id): array
    {
        $field = [
            'class_name',
            'id'
        ];

        $id = $this->getClassId($id);

        return Query::table(DbGoodsClass::class)->where('hide_status', 1)
            ->whereIn('id', $id)
            ->get($field)
            ->getResult([
                'items'
            ]);
    }

    /**
     * 获取分类编号
     *
     * @param array $data
     * @return array
     */
    private function getClassId(array $data): array
    {
        $one = array_column($data, 'class_id');

        $two = array_column($data, 'class_one');

        $three = array_column($data, 'class_three');

        return array_merge($one, $two, $three);
    }
}