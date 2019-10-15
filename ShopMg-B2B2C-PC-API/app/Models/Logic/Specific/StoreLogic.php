<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Store;
use App\Models\Entity\DbStoreEvaluate;
use App\Models\Entity\DbStoreFollow;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Swoft\Log\Log;
use Tool\Db;
use Tool\ParamsParse;

/**
 * 商铺逻辑处理层
 * @Bean()
 */
class StoreLogic extends AbstractLogic
{

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    /**
     * 店铺Id
     *
     * @var string
     */
    private $storeId = '';


    public function __construct()
    {
        $this->tableName = 'mg_store';
    }

    /**
     * 获取结果
     *
     * @deprecated
     *
     */
    public function getResult()
    {
        return [];
    }

    /**
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getStoreInfo(array $data, string $splitKey): array
    {
        $cache = &$this->cache;

        $key = implode('', array_column($data, $splitKey)) . 'storeinfo';

        $store = $cache->get($key);

        if ($store) {
            return json_decode($store, true);
        }

        $store = $this->getStoreInforByOtherData($data, $splitKey);

        if (0 === count($store)) {
            $this->errorMessage = '商户信息错误';
            return [];
        }

        $cache->set($key, json_encode($store, JSON_UNESCAPED_UNICODE), 160);

        return $store;
    }

    /**
     * 获取固定条件
     *
     * @return array
     */
    protected function fixedSearchConditions(): array
    {
        return [
            'status' => 1
        ];
    }

    /**
     * 根据其他数据获取店铺数据
     *
     * @return array
     */
    public function getStoreInforByOtherData(array $data, string $splitKey)
    {
        $idString = array_column($data, $splitKey);

        $field = [
            Store::$id,
            Store::$shopName,
            Store::$storeLogo
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn(Store::$id, $idString)
            ->select();

        return $data;
    }

    /**
     * 获取店铺数据
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getStoreByData(array $data, string $splitKey): array
    {
        $field = $this->commonField();

        $paramEntity = new ParamsParse($data, $field, Store::$id, $splitKey);

        $data = $this->parseAssociatedData($paramEntity);

        return $data;
    }

    /**
     * 获取店铺数据有缓存
     *
     * @param array $data
     * @param string $splitKey
     * @return array
     */
    public function getStoreByDataByCache(array $data, string $splitKey): array
    {
        $key = implode('', array_column($data, $splitKey)) . '_store_ddd';

        $cacheData = $this->cache->get($key);

        if ($cacheData) {
            return json_decode($cacheData, true);
        }

        $cacheData = $this->getStoreByData($data, $splitKey);

        if (0 === count($cacheData)) {
            return [];
        }

        $this->cache->set($key, json_encode($cacheData, JSON_UNESCAPED_UNICODE), 60);

        return $cacheData;
    }

    /**
     * 公共字段
     *
     * @return array
     */
    private function commonField(): array
    {
        return [
            Store::$id,
            Store::$shopName
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return Store::class;
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
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
        return [
            Store::$shopName
        ];
    }

    /**
     * 获取店铺详情
     */
    public function getShopDetails(array $post): array
    {
        // 获取店铺的基本信息 logo图 店铺名称 根据用户来查询联系方式 店铺简介 开店时间 所在区域
        $storeInfo = $this->getQueryBuilderProxy()
            ->field([
                Store::$id,
                Store::$storeLogo,
                Store::$description,
                Store::$shopName,
                Store::$createTime
            ])
            ->where('id', $post['id'])
            ->find();
        if (0 === count($storeInfo)) {
            $this->errorMessage = '店铺异常';
            return [];
        }

        // 是否关注了店铺
        $userId = session()->get('user_id');

        $if_atten = [];

        if ($userId) {
            $if_atten = DbStoreFollow::findOne([
                'user_id' => $userId,
                'store_id' => $post['id']
            ], [
                'column' => 'id'
            ])->getResult([
                'items'
            ]);
        }

        if ($if_atten) {
            $storeInfo['if_atten'] = 0;
        } else {
            $storeInfo['if_atten'] = 1;
        }
        // 获取店铺粉丝数
        $storeInfo['storeFans'] = DbStoreFollow::count('*', [
            'store_id' => $post['id']
        ])->getResult([
            'items'
        ]);

        // 店铺评分 描述相符评分 desccredit 服务态度评分servicecredit
        // //描述相符评分
        $storeParse = DbStoreEvaluate::query()->where('store_id', $post['id'])
            ->groupBy('store_id')
            ->one([
                'AVG(servicecredit) as servicecredit',
                'AVG(deliverycredit) as deliverycredit',
                'AVG(desccredit) as desccredit'
            ])
            ->getResult([
                'items'
            ]);
        if ($storeParse) {
            $storeInfo['servicecredit'] = $storeParse->getServicecredit();

            $storeInfo['deliverycredit'] = $storeParse->getDeliverycredit();

            $storeInfo['desccredit'] = $storeParse->getDesccredit();
        } else {
            $storeInfo['servicecredit'] = '0';

            $storeInfo['deliverycredit'] = '0';

            $storeInfo['desccredit'] = '0';
        }

        return $storeInfo;
    }

    public function calculationScoreAll($score, $scoreAll)
    {
        if ($scoreAll == 0) {
            return "高于同行0.00%";
        }
        $a_score = $score - $scoreAll;
        if ($a_score <= 0) {
            return "高于同行0.00%";
        }
        return "高于同行" . round($a_score / $scoreAll, 2) . "%";
    }

    /**
     * 更新店铺销量
     */
    public function updateSale(array $data)
    {
        $sql = $this->buildUpdateSql($data);
        try {
            $status = Db::query($sql)->getResult('items');

            return $status;
        } catch (\Exception $e) {

            Log::error('增加粉丝失败', [
                $sql,
                $e->getMessage()
            ]);

            Db::rollback();
            return false;
        }
    }

    /**
     * 要更新的字段
     *
     * @return array
     */
    protected function getColumToBeUpdated(): array
    {
        return [
            Store::$storeSales
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            Store::$id,
            Store::$shopName,
            Store::$storeSales,
            Store::$storeCollect,
            Store::$storeLogo,
            Store::$isOwn,
            Store::$classId
        ];
    }

    /**
     * 要更新的数据【已经解析好的】
     *
     * @return array
     */
    protected function getDataToBeUpdated(array $data): array
    {
        $tmp = [];

        foreach ($data as $store => $value) {
            $tmp[$value['store_id']][] = Store::$storeSales . ' + 1';
        }

        return $tmp;
    }

    /**
     *
     * @param array $info
     * @param string $splitKey
     * @return array
     */
    public function getInfo(array $info, string $splitKey): array
    {
        $cackeKey = 'storeonce_' . $info[$splitKey];

        $cache = &$this->cache;

        $data = $cache->get($cackeKey);

        if (!empty($data)) {
            return json_decode($data, true);
        }

        $data = $this->getQueryBuilderProxy()
            ->field([
                Store::$shopName,
                Store::$storeLogo,
                Store::$id
            ])
            ->where(Store::$id, $info[$splitKey])
            ->find();

        if (empty($data)) {
            $this->errorMessage = '商铺信息错误';
            return [];
        }

        $cache->set($cackeKey, json_encode($data, JSON_UNESCAPED_UNICODE), 60);

        return $data;
    }

    /**
     * 获取自营店铺
     *
     * @return array
     */
    public function getSelfStoreList(array $post): array
    {
        $options = [
            'where' => [
                Store::$storeState => 1,
                Store::$isOwn => 1
            ],
            'field' => [
                Store::$id
            ]
        ];

        $data = $this->getDataByPage($post, $options);

        if (0 === count($data['data'])) {

            $this->errorMessage = '店铺数据异常';

            return [];
        }

        return $data;
    }

    
    /**
     * 店铺街换一换获取数据
     */
    public function getShopStreetForAChange(array $post): array
    {
        $pageNumber = $this->getPageNumber();

        $pageStart = ($post['page'] - 1) * $pageNumber;

        $data = $this->getQueryBuilderProxy()
            ->field([
                Store::$id,
                Store::$shopName,
                Store::$storeLogo
            ])
            ->where(Store::$storeState, 1)
            ->where(Store::$status, 1)
            ->order(Store::$storeSales, 'DESC')
            ->limit($pageNumber, $pageStart)
            ->select();

        return $data;
    }

    public function getStoreByContrast(array $data, string $splitKey): array
    {
        $field = [
            Store::$id,
            Store::$shopName,
            Store::$storeLogo
        ];

        $paramEntity = new ParamsParse($data, $field, Store::$id, $splitKey);

        $data = $this->parseAssociatedData($paramEntity);

        return $data;
    }

    /**
     * 获取店铺信息
     */
    public function getStoreInfoByStoreIdString(array $data, string $splitKey): array
    {
        $idString = $this->getStoreIdString($data, $splitKey);

        return $this->getQueryBuilderProxy()
            ->field([
                Store::$shopName,
                Store::$storeLogo,
                Store::$id
            ])
            ->whereIn(Store::$id, $idString)
            ->select();
    }

    /**
     * 获取店铺信息
     */
    public function getStoreInfoByStoreIdStringCache(array $data, string $splitKey): array
    {
        $key = $this->getStoreIdString($data, $splitKey);

        $key = implode('', $key) . '_what_store';

        $cache = &$this->cache;

        $cacheData = $cache->get($key);

        if ($cacheData) {
            return json_decode($cacheData, true);
        }

        $cacheData = $this->getStoreInfoByStoreIdString($data, $splitKey);

        if (0 === count($data)) {
            $this->errorMessage = '没有店铺信息';
            return [];
        }

        $cache->set($key, json_encode($cacheData, JSON_UNESCAPED_UNICODE), 60);

        return $cacheData;
    }

    /**
     * 获取店铺信息
     */
    protected function getStoreIdString(array $data, string $splitKey): array
    {
        if ($this->storeId !== '') {
            return $this->storeId;
        }

        $this->storeId = array_unique(array_column($data, $splitKey));

        return $this->storeId;
    }

    /**
     * 【首页】搜索商品
     */
    public function searchByIndexHome(array $post): array
    {
        $args = [];

        $args[Store::$shopName] = $post['title'];

        $args[Store::$storeState] = 1;

        $args['page'] = $post['page'];

        return $this->getParseDataByList($args);
    }

    /**
     * 【首页】搜索商品
     */
    public function getStoreList(array $param, array $assoccWhere): array
    {
        return $this->getParseDataByList($param, [
            [
                'id',
                'in',
                $assoccWhere
            ]
        ]);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::searchArray()
     */
    public function searchArray(): array
    {
        return [
            Store::$storeState,
            Store::$classId
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getSearchOrderKey() :array
     */
    protected function getSearchOrderKey(): array
    {
        return [
            Store::$storeCollect => 'DESC',
            Store::$credibility => 'DESC',
            Store::$createTime => 'DESC',
            Store::$storeSales => 'DESC'
        ];
    }

    /**
     * 获取店铺分类关联key
     *
     * @return string
     */
    public function getSplitKeyByStoreClassId(): string
    {
        return Store::$classId;
    }

    /**
     * 店铺增加粉丝数
     */
    public function storesIncreaseTheNumberOfFans(array $post): int
    {
        return $this->getQueryBuilderProxy()
            ->where('id', $post['id'])
            ->counter('store_collect');
    }

    /**
     * 店铺增加粉丝数（事物）
     */
    public function storesIncreaseTheNumberOfFansByTrancestation(array $post): bool
    {
        $res = $this->storesIncreaseTheNumberOfFans($post);

        if (!$this->traceStation($res)) {
            return false;
        }
        Db::commit();
        return true;
    }

    /**
     * 店铺减少粉丝数
     */
    public function storesReduceTheNumberOfFans(array $post): int
    {
        return $this->getQueryBuilderProxy()
            ->where('id', $post['id'])
            ->counter('store_collect', -1);
    }

    /**
     * 店铺减少粉丝数（事物）
     */
    public function storesReduceTheNumberOfFansByTrancestation(array $post): bool
    {
        $res = $this->storesReduceTheNumberOfFans($post);

        if (!$this->traceStation($res)) {
            return false;
        }
        Db::commit();
        return true;
    }
}
