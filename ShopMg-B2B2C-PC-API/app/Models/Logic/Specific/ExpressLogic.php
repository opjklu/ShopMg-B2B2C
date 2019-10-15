<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Express;
use App\Models\Entity\DbExpress;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;

/**
 * 快递逻辑处理层
 * @Bean()
 */
class ExpressLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbExpress::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'page' => [
                'number' => '必须输入分页信息'
            ]
        ];
        return $message;
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
        return Express::class;
    }

    /**
     * 获取快递公司信息
     *
     * @return array
     */
    public function getExpressData(array $data, string $splitKey): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                Express::$code,
                Express::$name,
                Express::$tel
            ])
            ->condition([
                Express::$id => $data[$splitKey],
                Express::$status => 1
            ])
            ->find();
    }

    /**
     * 获取快递公司信息
     *
     * @return array
     */
    public function getExpressDataCache(array $data, string $splitKey): array
    {
        $key = $data[$splitKey] . '_express_id';

        $cache = &$this->cache;

        $cacheData = $cache->get($key);

        if ($cacheData) {
            return json_decode($cacheData, true);
        }

        $cacheData = $this->getExpressData($data, $splitKey);

        if (count($cacheData) === 0) {
            return [];
        }

        $cache->set($key, json_encode($cacheData), 60);

        return $cacheData;
    }

    /**
     * 获取快递列表
     *
     * @return array
     */
    public function getExpressDataList(): array
    {
        $data = $this->getQueryBuilderProxy()
            ->field(Express::$id . ',' . Express::$name)
            ->where(Express::$status . ' = 1')
            ->select();

        return $data;
    }

    /**
     * 获取快递列表并缓存
     *
     * @return array
     */
    public function getExpressDataListCache(): array
    {
        $key = 'express_data_list';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getExpressDataList();

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data), 60);

        return $data;
    }

    /**
     * 是否已发货
     *
     * @return array
     */
    public function isDeliverGoods(array $data, string $splitKey): array
    {
        if ($data[$splitKey] == 0) {
            return [];
        }

        return $this->getExpressDataCache($data, $splitKey);
    }
}
