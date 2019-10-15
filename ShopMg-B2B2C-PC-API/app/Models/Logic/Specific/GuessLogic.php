<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Goods;
use App\Common\TraitClass\GoodsLogicCommonTraits;
use App\Models\Entity\DbGoods;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;

/**
 * 猜你喜欢
 * @Bean()
 *
 * @author wq
 *
 */
class GuessLogic extends AbstractLogic
{
    use GoodsLogicCommonTraits;

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    public function __construct()
    {
        $this->tableName = DbGoods::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getResult()
     */
    public function getResult()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        // TODO Auto-generated method stub
        return Goods::class;
    }

    /**
     * 根据评分获取商品
     */
    public function getGoodsByScore(array $post, array $goods): array
    {
        $goodsIdArray = explode('_', implode('_', array_keys($goods)));

        $goodsIdStrings = array_unique($goodsIdArray);

        $pageSize = 6;
        // 当前页之前还有多少
        $pageNumber = ($post['page'] - 1) * $pageSize;

        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn(Goods::$id, $goodsIdStrings)
            ->where(Goods::$approvalStatus, 1)
            ->where(Goods::$shelves, 1)
            ->order(Goods::$salesSum, 'DESC')
            ->limit($pageSize, $pageNumber)
            ->select();
        return $data;
    }

    /**
     * 获取推荐商品并缓存
     */
    public function getGoodsByScoreCache(array $post, array $data): array
    {
        $column = array_keys($data);

        $key = $post['page'] . implode('', $column) . 'guss';

        $cache = &$this->cache;

        $tmp = $cache->get($key);

        if ($tmp) {
            return json_decode($tmp, true);
        }

        $data = $this->getGoodsByScore($post, $data);

        if (0 === count($data)) {
            return [];
        }

        $cache->set($key, json_encode($data), 800);

        return $data;
    }

    /**
     * 获取猜你喜欢商品（未登录时猜你喜欢）
     *
     * @return array
     */
    public function getGuessLikeGoods(array $post, array $cookie): array
    {
        if (!isset($cookie['brand_id'])) {
            return [];
        }

        $brandIdArray = explode(',', $cookie['brand_id']);

        $classIdArray = explode(',', $cookie['class_id']);

        $minBrandId = min($brandIdArray);

        $maxBrandId = max($brandIdArray);

        $minClassId = min($classIdArray);

        $maxClassId = max($classIdArray);

        $field = $this->getTableColum();

        $field[] = Goods::$salesSum;

        $pageSize = 6;

        // 当前页之前还有多少

        $pageNumber = ($post['page'] - 1) * $pageSize;

        $data = $this->getQueryBuilderProxy()
            ->field($field)
            ->whereBetween(Goods::$brandId, $minBrandId, $maxBrandId)
            ->openWhere('or')
            ->whereBetween(Goods::$classTwo, $minClassId, $maxClassId)
            ->closeWhere()
            ->where(Goods::$approvalStatus, 1)
            ->where(Goods::$status, 0)
            ->order(Goods::$salesSum, 'DESC')
            ->limit($pageSize, $pageNumber)
            ->select();

        if (0 === count($data)) {
            return [];
        }

        foreach ($data as $key => $value) {
            if ($value[Goods::$pId] == 0) {
                unset($data[$key]);
            }
        }

        if (empty($data)) {
            return [];
        }
        $goods = [];

        $compare = false;

        // 只显示 同类商品销量最高的一个
        foreach ($data as $key => $value) {

            if (isset($goods[$value[Goods::$pId]])) {

                $compare = $goods[$value[Goods::$pId]][Goods::$salesSum] < $value[Goods::$salesSum];

                // 大于
                if ($compare === true) {
                    $goods[$value[Goods::$pId]] = $value;
                }
            } else {
                $goods[$value[Goods::$pId]] = $value;
            }
        }
        return array_values($goods);
    }
}