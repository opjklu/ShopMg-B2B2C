<?php

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreEvaluate;
use App\Models\Entity\DbStoreEvaluate;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 店铺评分
 *
 * @author wq
 * @Bean()
 */
class StoreEvaluateLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbStoreEvaluate::class;
    }

    /**
     * 获取结果
     */
    public function getResult()
    {
        // 获取店铺评分
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return StoreEvaluate::class;
    }

    /**
     * 获取店铺评分
     */
    public function getStoreScore(array $post)
    {
        $cache = &$this->cache;

        $key = 'store_score_data' . $post[StoreEvaluate::$storeId];

        $data = $cache->get($key);

        if ($data) {

            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field('AVG(desccredit) as desccredit,AVG(servicecredit) as servicecredit,AVG(deliverycredit) as deliverycredit')
            ->where(StoreEvaluate::$storeId, $post[StoreEvaluate::$storeId])
            ->find();

        if (0 === count($data)) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 22);

        return $data;
    }
}