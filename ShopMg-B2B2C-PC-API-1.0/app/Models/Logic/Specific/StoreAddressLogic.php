<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\StoreAddress;
use App\Models\Entity\DbStoreAddress;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\Db;

/**
 * 逻辑处理层
 * @Bean()
 */
class StoreAddressLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbStoreAddress::class;
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
        return StoreAddress::class;
    }

    /**
     * 获取省份数据
     *
     * @return mixed|NULL|unknown|string[]|unknown[]|object|array|mixed|NULL|unknown|string[]|unknown[]
     */
    public function getStoreAdressById()
    {
        $cache = Cache::getInstance('', [
            'expire' => 100
        ]);

        $res = $cache->get('store_address_by_prov');

        if (empty($res)) {
            $res = $this->getQueryBuilderProxy()
                ->field('DISTINCT ' . StoreAddress::$provId)
                ->select();
        } else {
            return $res;
        }
        if (empty($res)) {
            return [];
        }

        $cache->set('store_address_by_prov', $res);

        return $res;
    }

    /**
     * 获取地区相关字段
     */
    public function getSearchKeyByProv()
    {
        return StoreAddress::$provId;
    }

    /**
     * 获取店铺地址
     */
    public function getStoreAddressId(array $post): array
    {
        $field = [
            StoreAddress::$id,
            StoreAddress::$city,
            StoreAddress::$dist,
            StoreAddress::$provId => 'prov',
            StoreAddress::$address
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where(StoreAddress::$storeId, $post['store_id'])
            ->find();
    }

    /**
     * 获取店铺地址 并缓存
     *
     * @author 米糕网络团队
     */
    public function getStoreAddressIdCache(array $post): array
    {
        $key = $post['store_id'] . 'store_address';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getStoreAddressId($post);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data), 15);

        return $data;
    }

    /**
     * 添加店铺地址
     *
     * @return boolean
     */
    public function addAddressStore(array $data): bool
    {
        $result = $this->addData($data);

        if (!$this->traceStation($result)) {
            $this->errorMessage .= '、保存店铺地址失败';
            return false;
        }
        Db::commit();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Common\Logic\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $data = [];

        $data[StoreAddress::$dist] = $insert['dist'];

        $data[StoreAddress::$provId] = $insert['prov_id'];

        $data[StoreAddress::$address] = $insert['address'];

        $data[StoreAddress::$city] = $insert['city'];

        $data[StoreAddress::$storeId] = $insert['insert_id'];

        $time = time();

        $data[StoreAddress::$createTime] = $time;

        $data[StoreAddress::$updateTime] = $time;

        return $data;
    }

    /**
     * 保存 店铺地址信息
     */
    public function saveAddress(array $post): bool
    {
        $status = $this->saveData($post);

        if (!$this->traceStation($status)) {

            return false;
        }

        Db::commit();

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Common\Logic\AbstractLogic::getParseResultBySave()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $data = [];

        $data[StoreAddress::$id] = $update['address_id'];

        $data[StoreAddress::$dist] = $update['dist'];

        $data[StoreAddress::$provId] = $update['prov_id'];

        $data[StoreAddress::$address] = $update['address'];

        $data[StoreAddress::$city] = $update['city'];

        $data[StoreAddress::$updateTime] = time();

        return $data;
    }

    /**
     * 获取店铺关联条件
     *
     * @return array
     */
    public function getAssocConditionByStore(array $post): array
    {
        if (empty($post['prov_id'])) {
            return [];
        }

        $ids = $this->getQueryBuilderProxy()
            ->field([
                'store_id'
            ])
            ->where('prov_id', $post['prov_id'])
            ->select();
        if (0 === count($ids)) {
            $this->whereExits[] = false;
            return [];
        }

        // 表示已找到条件
        $this->whereExits[] = true;

        return array_column($ids, 'store_id');
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::searchArray()
     */
    protected function searchArray(): array
    {
        return [
            StoreAddress::$provId
        ];
    }

    /**
     * 获取地区id数组
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getAddressListCache(array $data, string $splitKey): array
    {
        $ids = array_column($data, $splitKey);

        $key = implode('', $ids) . 'store_address';

        $source = $this->cache->get($key);

        if ($source) {
            return json_decode($source, true);
        }

        $source = $this->getAddressList($ids);

        if (0 === count($source)) {
            return [];
        }

        $this->cache->set($key, json_encode($source, JSON_UNESCAPED_UNICODE), 10);

        return $source;
    }

    public function getAddressList(array $ids): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                'store_id',
                'prov_id' => 'prov',
                'city',
                'dist'
            ])
            ->whereIn('store_id', $ids)
            ->select();
    }

    /**
     * 获取地区id数组
     *
     * @param array $ids
     * @return array
     */
    public function getAreaIds(array $area): array
    {
        if (0 === count($area)) {
            return [];
        }

        $prov = array_column($area, 'prov');

        $city = array_column($area, 'city');

        $dist = array_column($area, 'dist');

        return array_merge($dist, $city, $prov);
    }
}
