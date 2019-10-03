<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Goods;
use App\Common\TraitClass\GoodsLogicCommonTraits;
use App\Models\Entity\DbGoods;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Tool\QueryBuilderProxy;

/**
 * 商品逻辑处理
 *
 * @author Administrator
 * @Bean()
 * @Bean()
 */
class GoodsItemLogic extends AbstractLogic
{
    use GoodsLogicCommonTraits;

    /**
     * @Inject("cache")
     *
     * @var \Swoft\Cache\Cache
     */
    private $cache;

    /**
     * 排序数组长度
     *
     * @var integer
     */
    private const ORDER_BY_KEY_LENGTH = 4;

    /**
     * 排序方式
     */
    private const ORDER_BY = [
        'ASC',
        'DESC'
    ];

    /**
     * 排序key
     *
     * @var array
     */
    private $orderByKey = [
        'sort_price_member', // 价格
        'sort_comment_member', // 人气
        'sort_sales_sum', // 销量
        'sort_type' // 自营
    ];


    public function __construct()
    {
        $this->tableName = DbGoods::class;
    }

    /**
     * *
     * 获取商品列表页
     *
     * if (!empty($post['sort'])){
     * $flag = $post['sort'];
     * switch ($flag) {
     * case 1:$order = 'sales_sum DESC';break;//销量由高到低
     * case 2:$order = 'sales_sum ASC';break;//销量由低到高
     * case 3:$order = 'comment_member DESC';break;//人气由高到低
     * case 4:$order = 'comment_member ASC';break;//人气由低到高
     * case 5:$order = 'price_member DESC';break;//价格由高到低
     * case 6:$order = 'price_member ASC';break;//价格由低到高
     * }
     * }else{
     * $flag = "";
     * $order = 'sort';
     * }
     */
    public function goodsList(array $condition, array $post): array
    {
        $page = $post['page'];

        $number = ($page - 1) * 15;

        $orderBy = $this->getOrderByByGoodsSoearch($post);

        $tableName = QueryBuilderProxy::getTableNameByClassName($this->tableName);

        $where = $this->getInherentConditionBySearch($tableName);

        $condition = $this->getConditionBySearch($condition, $tableName);

        $count = $this->getQueryBuilderProxy()
            ->field($this->parseTableColumnBySearch($tableName))
            ->innerJoin('(SELECT MAX(id) id FROM mg_goods where status = 0 and approval_status = 1 GROUP BY p_id HAVING p_id > 0 )', $tableName . '.id = goods.id', 'goods')
            ->condition($condition)
            ->condition($where)
            ->count();

        $queryObj = $this->getQueryBuilderProxy()
            ->field($this->parseTableColumnBySearch($tableName))
            ->innerJoin('(SELECT MAX(id) id FROM mg_goods where status = 0 and approval_status = 1 GROUP BY p_id HAVING p_id > 0 )', $tableName . '.id = goods.id', 'goods')
            ->condition($condition)
            ->condition($where)
            ->limit(15, $number);

        // 处理排序
        foreach ($orderBy as $key => $value) {
            $queryObj->order($key, $value);
        }

        $list = $queryObj->select();
        return [
            'count' => $count,
            'list' => $list,
            'page_size' => 15
        ];
    }

    /**
     * 获取固有条件
     *
     * @return array
     */
    protected function getInherentCondition(): array
    {
        $where = [];
        $where['shelves'] = 1;
        $where['status'] = 0;
        $where['approval_status'] = 1;
        return $where;
    }

    /**
     * 获取固有条件（商品搜索）
     *
     * @return array
     */
    protected function getInherentConditionBySearch(string $tableName): array
    {
        $where = [];

        $where[$tableName . '.shelves'] = 1;
        $where[$tableName . '.status'] = 0;
        $where[$tableName . '.approval_status'] = 1;

        return $where;
    }

    /**
     * 获搜索有条件（商品搜索）
     *
     * @return array
     */
    protected function getConditionBySearch($condition, string $tableName): array
    {
        foreach ($condition as $key => &$value) {

            $value[0] = $tableName . '.' . $value[0];
        }

        return $condition;
    }

    /**
     * 获取搜索排序
     *
     * @return array
     */
    protected function getOrderByByGoodsSoearch(array $post): array
    {
        $orderBy = [];

        $index = 0;

        for ($i = 0; $i < static::ORDER_BY_KEY_LENGTH; $i++) {

            if (!isset($post[$this->orderByKey[$i]])) {
                continue;
            }

            $index = (int)$post[$this->orderByKey[$i]] % 2;

            $orderBy[str_replace('sort_', '', $this->orderByKey[$i])] = static::ORDER_BY[$index];
        }

        return $orderBy;
    }

    /**
     * 获取字段用于商品搜索
     *
     * @return array
     */
    protected function parseTableColumnBySearch(string $tableName): array
    {
        $tableColumns = $this->getTableColum();

        foreach ($tableColumns as $key => & $value) {

            $value = $tableName . '.' . $value;
        }

        return $tableColumns;
    }

    /**
     * 根据商品销量获取商品
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
        return Goods::class;
    }

    /**
     * 获取店内排行商品
     *
     * @return array
     */
    public function getGoodsByStoreRankings(array $post): array
    {
        $price = session()->get('user_id') ? Goods::$priceMember : Goods::$priceMarket;

        $field = [
            Goods::$id,
            Goods::$title,
            $price => 'goods_price',
            Goods::$pId
        ];
        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition([
                [
                    Goods::$pId,
                    '>',
                    '0'
                ],
                [
                    Goods::$storeId,
                    '=',
                    $post['store_id']
                ],
                [
                    Goods::$approvalStatus,
                    '=',
                    '1'
                ],
                [
                    Goods::$shelves,
                    '=',
                    '1'
                ]
            ])
            ->select();
        return $data;
    }

    /**
     * 获取店内排行商品
     *
     * @return array
     */
    public function getGoodsByStoreRankingsCache(array $post): array
    {
        $key = $post['store_id'] . '_store_rankings';

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data != null) {
            return json_decode($data, true);
        }

        $data = $this->getGoodsByStoreRankings($post);

        if (count($data) === 0) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 160);

        return $data;
    }

    /**
     * 获取验证方法
     *
     * @return array
     */
    public function getValidateStoreId(): array
    {
        return [
            'store_id' => [
                'number' => '店铺编号必须是数字'
            ]
        ];
    }

    /**
     *
     * @return string
     */
    public function getSplitKeyByPid(): string
    {
        return Goods::$pId;
    }

    /**
     * 商品热词搜索验证
     */
    public function getvalidateByHotSearch(): array
    {
        return [
            'class_id' => [
                'number' => '商品分类必须是数字'
            ],

            'title' => [
                'required' => '商品关键词必传',
                'specialCharFilter' => '请不要输入特殊字符'
            ]
        ];
    }

    /**
     *
     * @return array
     */
    public function getHotSearchList(array $post): array
    {
        return $this->getParseDataByList($post, [
            [
                Goods::$pId,
                '>',
                0
            ]
        ]);
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
            Goods::$classId
        ];
    }
}