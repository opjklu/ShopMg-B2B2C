<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreClass;
use App\Models\Entity\DbStoreClass;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\ParamsParse;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class StoreClassLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbStoreClass::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'page' => [
                'required' => '必须输入分页信息'
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
        return StoreClass::class;
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

    /**
     * 获取店铺分类
     *
     * @return mixed|boolean|string|NULL|array|unknown|object|array
     */
    public function getStoreClass(): array
    {
        $cache = &$this->cache;

        $key = 'store_class_data';

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $field = [
            'id',
            'sc_name',
            'sc_bail'
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->where('status', 1)
            ->select();

        if (0 === count($data)) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 77);

        return $data;
    }

    /**
     * 根据店铺数据获店铺分类数据
     *
     * @param array $storeData
     * @param string $splitKey
     * @return array
     */
    public function getStoreClassByStore(array $storeData, string $splitKey): array
    {
        $paramEntity = new ParamsParse($storeData, [
            'id',
            'sc_name'
        ], StoreClass::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }
}
