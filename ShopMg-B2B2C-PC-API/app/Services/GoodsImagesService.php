<?php
declare(strict_types=1);

namespace App\Services;

use App\Lib\GoodsImagesInterface;
use App\Models\Entity\DbGoodsImages;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Swoft\Db\Query;
use Swoft\Rpc\Server\Bean\Annotation\Service;

/**
 * 商品图片服务
 *
 * @author Administrator
 * @method ResetInterface deferGetGoodsImageById(string $goodsId)
 * @Service()
 */
class GoodsImagesService implements GoodsImagesInterface
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    /**
     * 根据商品编号获取图片
     */
    public function getGoodsImageById(string $goodsId): array
    {
        $key = 'images_' . $goodsId;

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, JSON_UNESCAPED_UNICODE);
        }

        $data = Query::table(DbGoodsImages::class)->where('goods_id', $goodsId)
            ->where('is_thumb', 0)
            ->get([
                'id',
                'goods_id',
                'pic_url'
            ])
            ->getResult([
                'items'
            ]);

        if (empty($data)) {
            return [];
        }

        $this->cache->set($key, json_encode($data), 60);

        return $data;
    }
}