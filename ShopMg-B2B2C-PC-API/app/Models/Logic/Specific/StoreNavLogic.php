<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreNav;
use App\Models\Entity\DbStoreNav;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 商铺逻辑处理层
 *
 * @Bean()
 */
class StoreNavLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbStoreNav::class;
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
        return StoreNav::class;
    }

    // 获取店铺导航
    public function getStoreNav(array $post): array
    {
        $where['store_id'] = $post['id'];
        $where['is_show'] = 1;
        $field = [
            'id',
            'name',
            'url'
        ];
        return $this->getQueryBuilderProxy()
            ->field($field)
            ->condition($where)
            ->order('order_by')
            ->select();
    }

    /**
     * /获取店铺导航有缓存
     *
     * @param array $post
     * @return array
     */
    public function getStoreNavCache(array $post): array
    {
        $key = 'store_nav' . $post['id'];

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getStoreNav($post);

        if (0 === count($data)) {
            return [];
        }

        $this->cache->scode($data, json_decode($data, JSON_UNESCAPED_UNICODE), 50);

        return $data;
    }
}
