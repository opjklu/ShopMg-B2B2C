<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\GoodsPackageSub;
use App\Models\Entity\DbGoodsPackageSub;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\ArrayChildren;

/**
 * 商品套餐
 *
 * @author Administrator
 *
 * @Bean()
 */
class GoodsPackageSubLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbGoodsPackageSub::class;
    }

    /**
     * 获取结果
     */
    public function getResult()
    {
    }

    /**
     * 获取套餐数据
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getPackageSub(array $data, string $splitKey): array
    {
        $column = array_column($data, $splitKey);

        $packageIdString = implode('', $column);

        $cackeKey = 's_package_sub' . $packageIdString;

        $cache = &$this->cache;

        $res = $cache->get($cackeKey);

        if ($res) {
            return json_decode($res, true);
        }

        $res = $this->getQueryBuilderProxy()
            ->field([
                GoodsPackageSub::$id,
                GoodsPackageSub::$packageId,
                GoodsPackageSub::$goodsId,
                GoodsPackageSub::$discount => 'goods_discount'
            ])
            ->whereIn(GoodsPackageSub::$packageId, $column)
            ->select();

        if (0 === count($data)) {
            $this->errorMessage = '套餐商品获取失败';
            return [];
        }

        $ss = $cache->set($cackeKey, json_encode($res), 60);

        return $res;
    }

    /**
     * 获取套餐商品
     *
     * @return array
     */
    public function getGoodsPackageSubListByPackageCache(array $packageGoods, string $splitKey): array
    {
        $packageIds = array_column($packageGoods, $splitKey);

        $key = implode('', $packageIds) . 'whate_sub_g';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getGoodsPackageSubListByPackage($packageIds);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 30);

        return $data;
    }

    /**
     * 处理商品是否在套餐内
     *
     * @return array
     */
    public function parseGoodsIsInPackage(array $packageGoods, array $post, string $splitKey): array
    {
        $data = $this->getGoodsPackageSubListByPackageCache($packageGoods, $splitKey);

        if (empty($data)) {
            return [];
        }

        $args = &$post;

        $temp = [];

        foreach ($data as $key => $value) {

            $temp[$value[GoodsPackageSub::$packageId]][] = $value[GoodsPackageSub::$goodsId];
        }

        $package = [];

        foreach ($temp as $key => $value) {
            if (!in_array($args['goods_id'], $value)) {
                $package[] = $key;
            }
        }

        if (($length = count($package)) === 0) {
            return $data;
        }

        $threeDimensionalArray = (new ArrayChildren($data))->inTheSameState(GoodsPackageSub::$packageId);

        $subData = [];

        $i = 0;

        foreach ($temp as $key => $value) {

            $subData = array_merge($threeDimensionalArray[$key], $subData);
        }

        return $subData;
    }

    /**
     * 获取套餐商品
     *
     * @return array
     */
    public function getGoodsPackageSubListByPackage(array $packageIds): array
    {
        $data = $this->getQueryBuilderProxy()
            ->field([
                GoodsPackageSub::$id,
                GoodsPackageSub::$packageId,
                GoodsPackageSub::$goodsId,
                GoodsPackageSub::$discount => 'goods_discount'
            ])
            ->whereIn(GoodsPackageSub::$packageId, $packageIds)
            ->select();

        if (count($data) === 0) {
            $this->errorMessage = '商品套餐数据有误';

            return [];
        }
        return $data;
    }

    /**
     * 获取商品套餐信息
     *
     * @return array
     */
    public function getGoodsPackageSub(): array
    {
        $field = [
            GoodsPackageSub::$id,
            GoodsPackageSub::$packageId,
            GoodsPackageSub::$goodsId,
            GoodsPackageSub::$discount
        ];

        $data = $this->getDataByOtherModel($field, GoodsPackageSub::$packageId);

        return $data;
    }

    /**
     * 获取套餐数据
     */
    public function getPackageSubInfoByOrderPackage()
    {
        $packageData = $this->getResult();

        if (empty($packageData)) {
            $this->getQueryBuilderProxy()->rollback();
            $this->errorMessage = '找不到套餐商品信息';
            return [];
        }

        return $packageData;
    }

    public function getMapperClassName(): string
    {
        return GoodsPackageSub::class;
    }

    /**
     * 根据购物车数据获取套餐数据
     *
     * @return array
     */
    public function getGoodsPackageSubDataByGoodsCart(array $data, string $splitKey): array
    {
        $packageIdString = implode('', array_column($data, $splitKey));

        $cackeKey = 'heppend_package_sub' . $packageIdString;

        $cache = &$this->cache;

        $res = $cache->get($cackeKey);

        if ($res) {
            return json_decode($res, true);
        }

        $res = $this->getSlaveDataByMaster($data, $splitKey);

        if (count($data) === 0) {
            $this->errorMessage = '套餐数据错误';
            return [];
        }

        $cache->set($cackeKey, json_encode($res), 60);

        return $res;
    }

    /**
     * 数据处理组合
     *
     * @param array $slaveData
     * @param string $slaveColumnWhere
     * @return array
     */
    protected function parseSlaveData(array $data, string $splitKey, array $slaveData, $slaveColumnWhere): array
    {
        foreach ($slaveData as $key => &$value) {
            if (empty($data[$value[$slaveColumnWhere]])) {
                continue;
            }
            unset($data[$value[$slaveColumnWhere]][$splitKey], $data[$value[$slaveColumnWhere]]['id']);
            $value = array_merge($value, $data[$value[$slaveColumnWhere]]);
        }
        return $slaveData;
    }

    /**
     * 获取从表字段（根据主表数据查从表数据的附属方法）
     *
     * @return array
     */
    protected function getSlaveField(): array
    {
        return [
            GoodsPackageSub::$packageId,
            GoodsPackageSub::$goodsId,
            GoodsPackageSub::$discount => 'goods_discount',
            GoodsPackageSub::$id
        ];
    }

    /**
     * 获取从表生成where条件的字段（根据主表数据查从表数据的附属方法）
     */
    protected function getSlaveColumnByWhere(): string
    {
        return GoodsPackageSub::$packageId;
    }

    public function getSplitKeyByGoods(): string
    {
        return GoodsPackageSub::$goodsId;
    }
}
	