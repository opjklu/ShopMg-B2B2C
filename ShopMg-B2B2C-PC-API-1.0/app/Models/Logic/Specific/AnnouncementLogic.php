<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Announcement;
use App\Models\Entity\DbAnnouncement;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 逻辑处理层
 * @Bean()
 */
class AnnouncementLogic extends AbstractLogic
{

    /**
     * @Inject(name="cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbAnnouncement::class;
    }

    /**
     * 得到所有的公告
     */
    public function getAllAnnoucement(): array
    {
        return $this->getQueryBuilderProxy()
            ->field(['id', 'title'])
            ->limit(8)
            ->order('create_time', 'DESC')
            ->select();
    }

    /**
     * 缓存得到所有的公告
     */
    public function getAllAnnoucementCache(): array
    {
        $key = 'announ-list-time';

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getAllAnnoucement();

        if (0 === count($data)) {
            return [];
        }

        $this->cache->set($key, json_encode($data), 200);

        return $data;
    }

    /**
     * 获取店品牌数据
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
        return Announcement::class;
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
}
