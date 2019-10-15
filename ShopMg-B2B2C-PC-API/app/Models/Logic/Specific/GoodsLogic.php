<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Goods;
use App\Common\TraitClass\GoodsLogicCommonTraits;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Swoft\Log\Log;
use Tool\Db;
use Tool\ParamsParse;
use Tool\QueryBuilderProxy;

/**
 * 逻辑处理层
 * @Bean()
 */
class GoodsLogic extends AbstractLogic
{
    use GoodsLogicCommonTraits;

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    public function getCacheDriver()
    {
        return $this->cache;
    }


    public function __construct()
    {
        $this->tableName = 'mg_goods';
    }

    /**
     * 获取 商品图片相关字段
     */
    public function getImagesByGoods()
    {
        return Goods::$pId;
    }

    /**
     * 根据商品销量获取商品
     */
    public function getResult()
    {
    }

    /**
     * 获取最新的商品
     */
    public function getGoodsByNew()
    {
        $cache = Cache::getInstance('', [
            'expire' => 30
        ]);

        $key = 'goods_recomend_new';

        $data = $cache->get($key);

        if (!$data) {
            return $data;
        }

        $field = [
            Goods::$id,
            Goods::$title,
            Goods::$priceMember,
            Goods::$priceMarket,
            Goods::$description,
            Goods::$storeId
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(Goods::$recommend . ' = 1 and ' . Goods::$approvalStatus . ' = 1')
            ->order(Goods::$createTime . ' DESC ')
            ->limit(3)
            ->select();

        if (empty($data)) {
            return [];
        }

        $cache->set($key, $data);

        return $data;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::parseWhereAgin()
     */
    protected function parseWhereAgin($where)
    {
        $where .= ' and ' . Goods::$approvalStatus . ' = 1';

        return $where;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return Goods::class;
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
     * 验证信息
     *
     * @return array
     */
    public function getValidateByContrast(): array
    {
        return [
            'contrast_id' => [
                'checkStringIsNumber' => '必须是数字加逗号的组合'
            ]
        ];
    }

    /**
     * 返回验证数据
     */
    public function getValidateBySearchGoods(): array
    {
        $message = [
            'title' => [
                'required' => '必须输入搜索关键字'
            ]
        ];
        return $message;
    }

    /**
     * 获取子类数据
     */
    public function getGoodsChildrenById(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                Goods::$pId
            ])
            ->where(Goods::$id, $post['id'])
            ->find();
    }

    /**
     * 获取商品父及id
     */
    public function getGoodsChildrenByIdCache(array $post): string
    {
        $key = 'goods_p_id' . $post['id'];

        $data = $this->cache->get($key);

        if ($data) {
            return $data;
        }

        $data = $this->getGoodsChildrenById($post);

        if (count($data) === 0) {
            return '';
        }

        $this->cache->set($key, $data['p_id'], 600);

        return $data['p_id'];
    }

    /**
     * 获取子类商品【上架的】
     *
     * @param int $pId
     *            商品父级编号
     * @return array
     */
    public function getChildrenGoods(array $post)
    {
        $pId = $this->getGoodsChildrenByIdCache($post);

        $cache = &$this->cache;

        $key = $post['id'] . '_kjd';

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $field = [
            Goods::$id,
            Goods::$title,
            Goods::$brandId,
            Goods::$pId,
            Goods::$description,
            Goods::$classId,
            Goods::$priceMarket,
            Goods::$priceMember
        ];
        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition([
                Goods::$pId => $pId,
                Goods::$shelves => 1,
                Goods::$approvalStatus => 1,
                Goods::$shelves => 1
            ])
            ->select();

        if (0 === count($data)) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 60);

        return $data;
    }

    /**
     * 获取普通商品详情
     */
    public function getGoodInfo(array $post): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                'id' => $post[Goods::$id],
                'approval_status' => 1,
                'shelves' => 1,
                'status' => 0
            ])
            ->find();
    }

    /**
     * 获取全部商品中的一个详情
     */
    public function getGoodInfoByOneOfTheTotalCommodities(array $post, string $splitKey): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                'id' => $post[$splitKey],
                'approval_status' => 1,
                'shelves' => 1
            ])
            ->find();
    }

    /**
     * 获取全部商品中的一个详情缓存
     */
    public function getGoodInfoByOneOfTheTotalCommoditiesCache(array $post, string $splitKey = 'id'): array
    {
        $key = 'goods_detaiOneofthetotalcommoditiesl_id' . $post[$splitKey];

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getGoodInfoByOneOfTheTotalCommodities($post, $splitKey);

        if (count($data) === 0) {
            $this->errorMessage = '未找到商品或商品以下架';
            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 20);

        return $data;
    }

    /**
     * 获取商品详情
     */
    public function getGoodInfoCache(array $post): array
    {
        $key = 'goods_detail_id' . $post[Goods::$id];

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getGoodInfo($post);

        if (count($data) === 0) {
            $this->errorMessage = '未找到商品或商品以下架';
            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 20);

        return $data;
    }

    /**
     * 根据商品收藏获取商品
     */
    public function getGoodsByCollect(array $data, string $spiltKey): array
    {
        $field = [
            Goods::$id,
            Goods::$title,
            Goods::$priceMember,
            Goods::$priceMarket,
            Goods::$pId
        ];

        $paramEntity = new ParamsParse($data, $field, Goods::$id, $spiltKey);

        $goods = $this->getDataByOtherModel($paramEntity);

        return $goods;
    }

    /**
     * 根据获取的积分商品获取商品信息
     */
    public function getGoodsDataByIntegral(array $data, string $splitKey): array
    {
        $field = [
            Goods::$id,
            Goods::$priceMember,
            Goods::$title,
            Goods::$pId
        ];

        $paramEntity = new ParamsParse($data, $field, Goods::$id, $splitKey);

        $goods = $this->parseAssociatedData($paramEntity);

        return $goods;
    }

    /**
     * 根据获取的积分获取商品信息
     */
    public function getGoodsDataByIntegralCache(array $args): array
    {
        $key = $args['p'] . '_integral_goods_8844';

        $cache = Cache::getInstance('', [
            'expire' => 120
        ]);

        $data = $cache->get($key);

        if (!empty($data)) {
            return $data;
        }

        $data = $this->getGoodsDataByIntegral();

        if (count($data) === 0) {
            $this->errorMessage = '商品已删除或积分数据异常';
            return [];
        }

        $cache->set($key, $data);

        return $data;
    }

    /**
     * 获取商品详情（无缓存）
     *
     * @return array
     */
    public function getGoodsDetailById(array $param, string $splitKey): array
    {
        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                Goods::$shelves => 1,
                Goods::$approvalStatus => 1,
                Goods::$id => $param[$splitKey]
            ])
            ->find();

        if (empty($data)) {
            $this->errorMessage = '商品信息错误';
            return [];
        }
        return $data;
    }

    /**
     * 获取商品详情（无缓存）
     *
     * @return array
     */
    public function getPanicGoodsDetailById(array $post, string $splitKey): array
    {
        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                Goods::$id => $post[$splitKey],
                Goods::$shelves => 1,
                Goods::$approvalStatus => 1,
                Goods::$status => 5
            ])
            ->find();

        return $data;
    }

    /**
     * 商品详情
     */
    public function getPanicGoodsDetailCacheKey(array $post, $splitKey)
    {
        $key = 'goods_panic_ddddd_detail' . $post[$splitKey];

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getPanicGoodsDetailById($post, $splitKey);

        if (0 === count($data)) {
            $this->errorMessage = '没有找到这个商品任何信息';
            return [];
        }

        $cache->set($key, $data);

        return $data;
    }

    /**
     * 商品详情
     */
    public function getGoodsDetailCacheKey(array $post, string $splitKey): array
    {
        $key = 'goods_detail' . $post[$splitKey];

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getGoodsDetailById($post, $splitKey);

        if (0 === count($data)) {
            $this->errorMessage = '没有找到这个商品任何信息';
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 60);

        return $data;
    }

    /**
     * 获取商品详情
     *
     * @return array
     */
    public function getGoodsDetailCache(array $param): array
    {
        $this->splitKey = 'id';

        $key = 'goods_detail' . $param['id'];

        $cache = &$this->cache;

        $data = $cache->get($key);

        if (!empty($data)) {
            return json_decode($data, true);
        }

        $data = $this->getGoodsDetailById($param, 'id');
        if (empty($data)) {
            $this->errorMessage = '没有找到这个商品任何信息';
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 80);

        return $data;
    }

    // 获取商品详情
    public function getGoodsDetailByOrder(array $param): array
    {
        $data = $this->getGoodsDetailCache($param);

        if (empty($data)) {
            return [];
        }

        unset($data[Goods::$priceMarket]);

        return $data;
    }

    /**
     * 获取自营店铺商品
     *
     * @return array
     */
    public function getSelfStoreGoods(array $storeData): array
    {

        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn(Goods::$storeId, array_column($storeData, 'id'))
            ->where( Goods::$pId, 0, '!=')
            ->where(Goods::$shelves, 1)
            ->where(Goods::$approvalStatus, 1)
            ->select();

        if (0 === count($data)) {

            $this->errorMessage = '没有自营商品';
            return [];
        }

        return $data;
    }

    /**
     * 根据店铺编号获取店铺全部商品列表
     */
    public function getGoodsListByStore(array $post): array
    {
        $tableName = QueryBuilderProxy::getTableNameByClassName($this->tableName);

        $count = $this->getQueryBuilderProxy()
            ->innerJoin('(SELECT MAX(id) id FROM mg_goods where status = 0 and approval_status = 1 GROUP BY p_id HAVING p_id > 0 )', $tableName . '.id = goods.id', 'goods')
            ->where($tableName . '.shelves', 1)
            ->where($tableName . '.approval_status', 1)
            ->where($tableName . '.status', 0)
            ->where('store_id', $post['id'])
            ->count();

        $number = ($post['page'] - 1) * 15;

        $queryObj = $this->getQueryBuilderProxy()
            ->field($this->getFloorField($tableName))
            ->innerJoin('(SELECT MAX(id) id FROM mg_goods where status = 0 and approval_status = 1 GROUP BY p_id HAVING p_id > 0 )', $tableName . '.id = goods.id', 'goods')
            ->where($tableName . '.shelves', 1)
            ->where($tableName . '.approval_status', 1)
            ->where($tableName . '.status', 0)
            ->where($tableName . '.store_id', $post['id']);

        $orderBy = $this->getOrderBySearch($post);

        foreach ($orderBy as $key => $value) {
            $queryObj->order($key, $value);
        }

        $list = $queryObj->limit(15, $number)->select();

        return [
            'count' => $count,
            'list' => $list,
            'page_size' => 15
        ];
    }

    /**
     * 获取积分热兑商品
     */
    public function getGoodsByIntegralHot(): array
    {
        $field = [
            Goods::$id,
            Goods::$pId,
            Goods::$title,
            Goods::$salesSum
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where('status', 3)
            ->where('approval_status', 1)
            ->where('shelves', 1)
            ->order('sales_sum', 'DESC')
            ->limit(6)
            ->select();
    }

    /**
     * 获取积分热兑商品
     */
    public function getGoodsByIntegralHotCache(): array
    {
        $key = 'goods_integral_list';

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getGoodsByIntegralHot();

        if (count($data) === 0) {
            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 45);

        return $data;
    }

    /**
     * 获取自营店铺商品
     *
     * @return array
     */
    public function getSelfStoreGoodsCache(array $args, array $storeData): array
    {
        $key = 'store_goods_key_self' . $args['p'];

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_encode($data);
        }
        

        $data = $this->getSelfStoreGoods($storeData);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data), 60);
        
        return $data;
    }

    /**
     * 获取品牌关联字段
     *
     * @return string
     */
    public function getSplitKeyByBrand(): string
    {
        return Goods::$brandId;
    }

    /**
     * 获取关联字段
     *
     * @return string
     */
    public function getSplitKeyByStore(): string
    {
        return Goods::$storeId;
    }

    /**
     * 验证库存是否足够
     */
    public function checkStock(array $stock)
    {
        $data = $this->getStock($stock);

        if (empty($data)) {
            return [];
        }

        foreach ($data as $key => $value) {

            if ($value[Goods::$stock] >= $stock[$key]) {
                continue;
            }

            $this->errorMessage = $value[Goods::$title] . '库存不足';

            return false;
        }
        return true;
    }

    /**
     * 获取库存
     */
    public function getStock(array $data): array
    {
        $goodsId = array_keys($data);

        $goods = $this->getQueryBuilderProxy()
            ->field([
                Goods::$id,
                Goods::$stock,
                Goods::$title
            ])
            ->whereIn(Goods::$id, $goodsId)
            ->getField();

        if (empty($goods)) {
            return [];
        }

        return $goods;
    }

    /**
     * 检测库存是否足够
     */
    public function isThereEnoughStock(array $post): bool
    {
        $data = $this->getQueryBuilderProxy()
            ->condition([
                'id' => $post['goods_id'],
                'shelves' => 1,
                'approval_status' => 1
            ])
            ->field([
                'stock'
            ])
            ->find();

        if (0 === count($data)) {
            $this->errorMessage = '库存错误';
            return false;
        }

        if ($data['stock'] < $post['num']) {

            $this->errorMessage = '库存已经不足';
            return false;
        }

        return true;
    }

    /**
     * 减少库存
     */
    public function delStock(array $data): bool
    {
        $sql = $this->buildUpdateSql($data);
        try {
            $status = Db::query($sql)->getResult('items');
            return $this->traceStation($status);
        } catch (\Exception $e) {

            $this->errorMessage = $e->getMessage();
            Log::error('sql -- 错误：', [
                $sql,
                $this->errorMessage
            ]);
            Db::rollback();
            return false;
        }
    }

    /**
     * 要更新的数据【已经解析好的】
     *
     * @return array
     */
    protected function getDataToBeUpdated(array $data): array
    {

        // 批量更新
        $pasrseData = array();

        foreach ($data as $key => $value) {
            if (empty($value['goods_num'])) {
                Db::rollback();
                return [];
            }
            $pasrseData[$value['goods_id']][] = Goods::$stock . '-' . $value['goods_num'];

            $pasrseData[$value['goods_id']][] = Goods::$salesSum . ' + ' . $value['goods_num'];
        }

        return $pasrseData;
    }

    /**
     * 要更新的字段
     *
     * @return array
     */
    protected function getColumToBeUpdated(): array
    {
        return [
            Goods::$stock,
            Goods::$salesSum
        ];
    }

    /**
     * 获取商品数据并缓存（购物车立即购买用）
     *
     * @return array
     */
    public function getGoodsByOtherDataCache(array $dataByCart, string $splitKey): array
    {
        $key = implode('', array_column($dataByCart, $splitKey)) . 'goods_cart_buy';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getGoodsByOtherData($dataByCart, $splitKey);

        if (0 === count($data)) {
            $this->errorMessage = '找不到对应的商品';
            return [];
        }

        $cache->set($key, json_encode($data), 45);

        return $data;
    }

    /**
     * 根据其他数据获取商品数据（map）
     */
    public function getGoodsByOtherData(array $data, string $splitKey)
    {
        $field = $this->commonField();

        $paramEntity = new ParamsParse($data, $field, Goods::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);

    }

    /**
     * 根据数据获取商品
     *
     * @return array
     */
    public function getGoodsByData(array $data, string $splitKey): array
    {
        $field = $this->commonField();

        $paramEntity = new ParamsParse($data, $field, Goods::$id, $splitKey);

        return $this->parseAssociatedData($paramEntity);
    }

    /**
     * 公共字段
     *
     * @return array
     */
    private function commonField(): array
    {
        return [
            Goods::$id,
            Goods::$priceMember,
            Goods::$pId,
            Goods::$storeId,
            Goods::$title,
            Goods::$weight,
            Goods::$expressId,
            Goods::$priceMarket
        ];
    }

    /**
     * 首页楼层显示的字段
     *
     * @return array
     */
    protected function getFloorField(string $table): array
    {
        /**
         *
         * @var SessionManager $sessionManager
         */
        $sessionManager = \Swoft\App::getBean('sessionManager');

        $session = $sessionManager->getSession();

        $userId = $session->get('user_id');

        $priceKey = $userId ? Goods::$priceMember : Goods::$priceMarket;

        $field = [
            $table . '.' . Goods::$id,
            $table . '.' . $priceKey . ' as goods_price',
            $table . '.' . Goods::$title,
            $table . '.' . Goods::$pId,
            $table . '.' . Goods::$description,
            $table . '.' . Goods::$salesSum
        ];

        return $field;
    }

    /**
     * 新品推荐(单个分类)
     */
    public function newArrivals(array $post): array
    {
        // 新品推荐
        return $this->parseSql()
            ->andWhere('master.class_id', $post['id'])
            ->andWhere('master.shelves', 1)
            ->andWhere('master.recommend', 1)
            ->limit(6)
            ->order('master.create_time', 'DESC')
            ->select();
    }

    /**
     * 新品推荐(全部分类)
     */
    public function newArrivalsAll(array $post): array
    {
        // 新品推荐
        return $this->parseSql()
            ->andWhere('master.shelves', 1)
            ->andWhere('master.recommend', 1)
            ->limit(6)
            ->order('master.create_time', 'DESC')
            ->select();
    }

    /**
     * 推荐商品(根据店铺)
     */
    public function recommendByStore(array $post): array
    {
        // 新品推荐
        return $this->parseSql()
            ->andWhere('master.shelves', 1)
            ->andWhere('master.recommend', 1)
            ->andWhere('master.store_id', $post['id'])
            ->limit(6)
            ->order('master.sales_sum', 'DESC')
            ->select();
    }

    /**
     * 新品上架(根据店铺)
     */
    public function newArrivalsAllByStore(array $post): array
    {
        // 新品推荐
        return $this->parseSql()
            ->andWhere('master.shelves', 1)
            ->andWhere('master.store_id', $post['id'])
            ->limit(6)
            ->order('master.create_time', 'DESC')
            ->select();
    }

    /**
     * 店铺--爆品专区
     */
    public function getDetonating(array $post): array
    {
        // 店铺--爆品专区
        return $this->parseSql()
            ->andWhere('master.shelves', 1)
            ->andWhere('master.selling', 1)
            ->andWhere('master.store_id', $post['id'])
            ->limit(8)
            ->order('master.sales_sum', 'DESC')
            ->select();
    }

    /**
     * 解析SQL语句
     *
     * @return string
     */
    private function parseSql(): QueryBuilderProxy
    {
        $field = $this->getFloorField('master');

        return $this->getQueryBuild($field);
    }

    /**
     * 构建查询对象
     *
     * @param array $field
     * @return QueryBuilderProxy
     */
    private function getQueryBuild(array $field): QueryBuilderProxy
    {
        return $this->getQueryBuilderProxy('master')
            ->field($field)
            ->innerJoin('(SELECT MAX(id) id FROM mg_goods where status = 0 and approval_status = 1 GROUP BY p_id HAVING p_id > 0 )', 'master.id = goods.id', 'goods')
            ->andWhere('master.status', 0)
            ->andWhere('master.approval_status', 1);
    }

    /**
     * 热卖商品(具体分类中)
     */
    public function hotSellingGoods(array $post): array
    {
        // 热卖商品
        return $this->parseSql()
            ->andwhere('master.class_id', $post['id'])
            ->andWhere('master.shelves', 1)
            ->andWhere('master.selling', 1)
            ->limit(6)
            ->order('master.sales_sum', 'DESC')
            ->select();
    }

    /**
     * 热卖商品(全部分类中)
     */
    public function hotSellingGoodsAll(array $post = []): array
    {
        // 热卖商品
        return $this->parseSql()
            ->andWhere('master.shelves', 1)
            ->andWhere('master.selling', 1)
            ->limit(6)
            ->order('master.sales_sum', 'DESC')
            ->select();
    }

    /**
     * 疯狂抢购
     *
     * @return array
     */
    public function panicBuying(array $post): array
    {
        // 疯狂抢购
        return $this->parseSql()
            ->andwhere('master.class_id', $post['id'])
            ->andWhere('master.shelves', 1)
            ->andWhere('master.status', 5)
            ->limit(6)
            ->order('master.sort')
            ->select();

    }

    /**
     * 猜你喜欢
     *
     * @return array
     */
    public function guessWhatYouLike(array $post): array
    {
        return $this->parseSql()
            ->andwhere('master.class_id', $post['id'])
            ->andWhere('master.shelves', 1)
            ->limit(6)
            ->order('master.sort')
            ->select();
    }

    /**
     * 获取对比商品
     */
    public function getContrastGoodsById(array $post): array
    {
        $field = $this->getTableColum();

        array_push($field, Goods::$brandId);

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn(Goods::$id, $post['contrast_id'])
            ->where(Goods::$approvalStatus, 1)
            ->where(Goods::$shelves, 1)
            ->select();
    }

    /**
     * 得到商品的详情
     */
    public function getGoodsInfoByGoodsId(array $source, string $splitKey): array
    {
        $cache = &$this->cache;

        $userId = session()->get('user_id');

        $key = $splitKey . '_' . $source[$splitKey] . 'goods_detail';

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $tmp = $userId ? $userId : '0';

        $moneyKey = $tmp === '0' ? Goods::$priceMarket : Goods::$priceMember;

        $field = [
            Goods::$id,
            Goods::$title,
            Goods::$pId,
            Goods::$stock,
            Goods::$storeId,
            Goods::$weight,
            Goods::$expressId,
            $moneyKey => 'price'
        ];

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(Goods::$id, $source[$splitKey])
            ->find();

        if (0 === count($data)) {
            $this->errorMessage = '没有该商品';
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 60);

        return $data;
    }

    /**
     * 分类关联key
     *
     * @return array
     */
    public function getClassIdKey(): array
    {
        return [
            Goods::$classId,
            Goods::$classTwo,
            Goods::$classThree
        ];
    }

    /**
     * 获取 商品数据
     *
     * @return array
     */
    public function getGoodsForData(array $data, string $splitKey): array
    {
        $key = implode('', array_column($data, $splitKey)) . '_ddk22';

        $cache = &$this->cache;

        $res = $cache->get($key);

        if ($res) {
            return json_decode($res, true);
        }

        $res = $this->getGoodsByOtherData($data, $splitKey);

        if (0 === count($res)) {
            $this->errorMessage = '找不到对应的商品';
            return [];
        }

        $cache->set($key, json_encode($res), 30);

        return $res;
    }

    /**
     * 套餐相关
     *
     * @return array
     */
    public function getParseDataByOrder(array $data, string $splitKey): array
    {
        $goodsData = $this->getGoodsForData($data, $splitKey);

        if (empty($goodsData)) {
            return [];
        }

        foreach ($goodsData as & $value) {
            $value['goods_num'] = '1';
        }

        return $goodsData;
    }

    /**
     * 套餐购物车购买兼容支付数据
     *
     * @return array
     */
    public function getParseDataCartByOrder(array $data, string $splitKey): array
    {
        $goodsData = $this->getGoodsForData($data, $splitKey);

        if (empty($goodsData)) {
            return [];
        }

        foreach ($goodsData as & $value) {
            $value['goods_num'] = $value['package_num'];
        }

        return $goodsData;
    }

    /**
     * 【首页】搜索商品
     */
    public function searchByIndexHome(array $post): array
    {
        $number = $this->getPageNumber();

        $startNumber = ($post['page'] - 1) * $number;

        $condition = [
            [
                Goods::$title,
                'like',
                $post['title'] . '%'
            ],
            [
                Goods::$shelves,
                '=',
                1
            ],
            [
                Goods::$approvalStatus,
                '=',
                1
            ]
        ];

        $data = $this->parseSql()
            ->condition($condition)
            ->order(Goods::$salesSum, 'DESC')
            ->limit($number, $startNumber)
            ->select();

        return [
            'data' => $data,
            'count' => $this->parseSql()
                ->condition($condition)
                ->count(),
            'page_size' => $number
        ];
    }

    /**
     * 获取具体搜索字段（非模糊）
     *
     * @return
     *
     */
    protected function searchArray(): array
    {
        return [
            Goods::$pId,
            Goods::$shelves,
            Goods::$approvalStatus,
            Goods::$storeId
        ];
    }

    /**
     * 获取排序
     */
    protected function getSearchOrderKey(): array
    {
        return [
            Goods::$salesSum => 'DESC',
            Goods::$recommend => 'DESC',
            Goods::$createTime => 'DESC',
            Goods::$selling => 'DESC',
            Goods::$priceMember => 'ASC'
        ];
    }

    /**
     * 店内搜索验证
     *
     * @return array
     */
    public function getValidateByShopSearch(): array
    {
        return [
            'left' => [
                'number' => '最小金额必须是数字'
            ],

            'reight' => [
                'number' => '最大金额必须是数字'
            ],

            'title' => [
                'specialCharFilter' => '请不要输入特殊字符'
            ],
            'store_id' => [
                'number' => '店铺id必须是数字'
            ]
        ];
    }

    /**
     * 根据店铺信息获取商品信息
     */
    public function getGoodsListByStoreInfo(array $store): array
    {
        $storeIds = array_column($store, 'id');

        return $this->getQueryBuild($this->getFieldByIsLogin())
            ->whereIn('store_id', $storeIds)
            ->order('master.sales_sum', 'DESC')
            ->limit(3)
            ->select();
    }

    /**
     * 获取字段区别是否登录
     *
     * @return array
     */
    private function getFieldByIsLogin(): array
    {
        $field = [
            'master.' . Goods::$id,
            'master.' . Goods::$pId,
            'master.' . Goods::$storeId,
            'master.' . Goods::$title,
            'master.' . Goods::$weight,
            'master.' . Goods::$expressId
        ];

        $userId = session()->get('user_id');

        if ($userId) {
            $field[] = 'master.' . Goods::$priceMember . ' as goods_price';
        } else {
            $field[] = 'master.' . Goods::$priceMarket . ' as goods_price';
        }

        return $field;
    }

    /**
     * 店内搜搜商品
     *
     * @return array
     */
    public function searchListByStore(array $post, array $data): array
    {

        return $this->getParseDataByList($post, [
            ['p_id', '>', 0],
            ['price_member', 'between', $data['left'], $data['reight']]
        ]);
    }

    /**
     * 验证 库存是否足够
     */
    public function getGoodsByIdString(array $data): array
    {
        return $this->getQueryBuilderProxy()
            ->field([
                Goods::$id,
                Goods::$storeId,
                Goods::$stock,
                Goods::$title
            ])
            ->whereIn(Goods::$id, explode(',', $data['contrast_id']))
            ->select();
    }

    /**
     * 查看库存是否足够
     *
     * @return array
     */
    public function checkGoodsStock(array $data): array
    {
        $data = $this->getGoodsByIdString($data);

        if (count($data) === 0) {
            $this->errorMessage = '商品数据错误';
            return [];
        }

        foreach ($data as $key => &$value) {
            if ($value[Goods::$stock] - 1 < 0) {

                $this->errorMessage = $value[Goods::$title] . '库存不足';

                return [];
            }

            $value['goods_num'] = 1;
        }

        return $data;
    }

    /**
     * 验证商品配件
     */
    public function getMessageByAccessories(): array
    {
        return [
            'goods_id' => [
                'required' => '商品编号必传',
                'checkStringIsNumber' => '必须是数字'
            ]
        ];
    }

    /**
     * 最佳配件商品立即购买缓存
     */
    public function bestAccessoriesImmediatePurchaseCache(array $post): array
    {
        $key = $post['goods_id'] . '_goods_id';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->bestAccessoriesImmediatePurchase($post);

        if (0 === count($data)) {
            return [];
        }

        $cache->set($key, json_encode($data), 60);

        return $data;
    }

    /**
     * 最佳配件商品立即购买
     */
    public function bestAccessoriesImmediatePurchase(array $post): array
    {

        $field = $this->getTableColum();

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn(Goods::$id, explode(',', $post['goods_id']))
            ->where(Goods::$approvalStatus, 1)
            ->where(Goods::$shelves, '1')
            ->select();

        if (empty($data)) {
            $this->errorMessage = '商品数据错误';
            return [];
        }

        foreach ($data as & $value) {
            $value['goods_num'] = '1';

            // 兼容订单商品添加
            $value['goods_id'] = $value[Goods::$id];
        }

        return $data;
    }

    /**
     * 获取组合商品
     *
     * @param array $data
     * @return array
     */
    public function getGoodsCombo(array $condition): array
    {

        if (!session()->get('user_id')) {
            $field = [
                'id',
                'price_market' => 'goods_price',
                'title',
                'p_id',
                'store_id'
            ];
        } else {
            $field = [
                'id',
                'price_market' => 'goods_price',
                'title',
                'p_id',
                'store_id'
            ];
        }

        return $this->getQueryBuilderProxy()
            ->whereIn('id', $condition)
            ->where('approval_status', 1)
            ->where('shelves', 1)
            ->field($field)
            ->select();
    }

    /**
     * 验证店内搜索
     *
     * @return array
     */
    public function vlidateParam(): array
    {
        return [
            'store_id' => [
                'number' => '店铺编号必须是数字'
            ],
            'title' => [
                'specialCharFilter' => '商品标题必须是数字、中英文其中的一个'
            ]
        ];
    }
}
