<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Nav;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * @Bean()
 *
 * @author 米糕网络团队
 */
class NavLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = 'mg_nav';
    }

    /**
     * 获取所有的分类模板
     */
    public function getPCNav()
    {
        $cache = &$this->cache;

        $list = $cache->get('adv_pc_cache');

        if ($list) {
            return json_decode($list, true);
        }

        $list = $this->getQueryBuilderProxy()
            ->field([
                'id',
                'nav_titile',
                'link'
            ])
            ->where('status', 1)
            ->where('platform', 0)
            ->limit(10)
            ->order('sort', 'ASC')
            ->select();

        if (0 === count($list)) {
            return [];
        }
        $cache->set('adv_pc_cache', json_encode($list, JSON_UNESCAPED_UNICODE, 60));
        return $list;
    }

    /**
     * 获取首页导航
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
        return Nav::class;
    }
}