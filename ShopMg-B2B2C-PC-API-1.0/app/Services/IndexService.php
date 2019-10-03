<?php
declare(strict_types=1);

namespace App\Services;

use App\Lib\IndexInterface;
use App\Models\Entity\DbAd;
use App\Models\Entity\DbAnnouncement;
use App\Models\Entity\DbStore;
use Swoft\Core\ResultInterface;
use Swoft\Db\Query;
use Swoft\Rpc\Server\Bean\Annotation\Service;

/**
 * 首页服务
 * @Service()
 * @author wq
 * @method ResultInterface deferGetHomeInfo()
 */
class IndexService implements IndexInterface
{

    /**
     * 获取首页的信息
     *
     * @return array
     */
    public function getHomeInfo(): array
    {
        $adData = Query::table(DbAd::class)->where('ad_space_id', 1)
            ->limit(5)
            ->get([
                'id',
                'title',
                'pic_url'
            ])
            ->getResult([
                'items'
            ]);

        $announcement = Query::table(DbAnnouncement::class)->where("status", 1)
            ->orderBy("sort")
            ->get([
                'id',
                'title'
            ])
            ->getResult([
                'items'
            ]);

        $store = Query::table(DbStore::class)->where('store_state', 1)
            ->where('status', 1)
            ->limit(24)
            ->get([
                'id',
                'shop_name',
                'store_logo'
            ])
            ->getResult([
                'items'
            ]);

        return [
            'banner' => $adData,
            'announcement' => $announcement,
            'store' => $store
        ];
    }
}