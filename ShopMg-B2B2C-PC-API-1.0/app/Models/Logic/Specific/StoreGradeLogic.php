<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreGrade;
use App\Models\Entity\DbStoreGrade;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class StoreGradeLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbStoreGrade::class;
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
        return StoreGrade::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::hideenComment()
     */
    public function hideenComment()
    {
        return [];
    }

    /**
     * *
     * 获取所有的店铺等级
     */
    public function shopLevelList(): array
    {
        return $this->getQueryBuilderProxy()
            ->where(StoreGrade::$status, 1)
            ->select();
    }

    public function shopLevelListCache(): array
    {
        $key = 'store_gradle111';

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->shopLevelList();

        if (0 === count($data)) {
            return [];
        }

        $this->cache->set($key, json_encode($data), 80);

        return $data;
    }

    /**
     * 获取店铺等级
     */
    public function getStoreGrade(array $data): array
    {
        $data = $this->getQueryBuilderProxy()
            ->field(array_values($this->getStaticProperties()))
            ->where(StoreGrade::$id, $data['level_id'])
            ->find();

        if (0 === count($data)) {
            return [];
        }
        session()->put('money', floatval($data[StoreGrade::$price]));
        return $data;
    }
}
