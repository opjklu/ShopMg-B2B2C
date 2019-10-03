<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\Panic;
use App\Models\Entity\DbPanic;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Redis\Redis;

/**
 * 逻辑处理层
 * @Bean()
 */
class PanicLogic extends AbstractLogic
{

    /**
     * @Inject()
     *
     * @var Redis
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbPanic::class;
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
        return Panic::class;
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
            'id',
            'goods_id',
            'panic_price',
            'already_num',
            'start_time'
        ];
    }

    /**
     * 获取商品关联key
     *
     * @return string
     */
    public function getSplitKeyByGoods(): string
    {
        return Panic::$goodsId;
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
     * 操作redis 添加库存
     */
    public function redisOperation(array $goods, array $panic): void
    {
        $time = time();

        if ($time < $panic['start_time'] || $time > $panic['end_time']) {
            // 抢购未开始 或已结束
            return;
        }

        if ($goods['stock'] <= 0) {

            // 没有库存了
            return;
        }

        $key = 'panic_key_zh' . $panic['id'];

        $cache = &$this->cache;

        $quantityLimit = $cache->get($key);

        if ($quantityLimit) {
            // 已入队
            return;
        }

        // 商品库存 小于抢购库存
        if ($goods['stock'] < $panic['panic_num']) {

            $panic['panic_num'] = $goods['stock'];
        }

        $goodsStoreKey = 'goods_store_panic' . $panic['id'];

        $handler = &$cache;

        // 库存
        $stock = $handler->lLen($goodsStoreKey);

        $userStockKey = $panic['id'] . '_panic_user_key';

        $userExits = $handler->hGetAll($userStockKey);

        if ($stock === 0 && count($userExits) === 0) {

            $count = ($panic['panic_num'] / $panic['quantity_limit']);

            $unsignedInt = (int)$count;

            for ($i = 0; $i < $unsignedInt; $i++) {

                $handler->lpush($goodsStoreKey, $panic['quantity_limit']);
            }

            if (is_float($count)) {

                // 取余
                $remainder = $panic['panic_num'] % $panic['quantity_limit'];

                $handler->rpush($goodsStoreKey, $remainder);
            }
        }

        $res = $handler->lLen($goodsStoreKey);

        if ($res === 0) {
            $this->errorMessage = '抢购繁忙';
        }

        $cache->set($key, $panic['quantity_limit'], $panic['end_time'] - $panic['start_time']);
    }

    /**
     * 抢购内页
     */
    public function innerPanic(array $post): array
    {
        $field = [
            'id',
            'goods_id',
            'panic_title',
            'panic_price',
            'start_time',
            'end_time',
            'already_num',
            'panic_num',
            'quantity_limit'
        ];

        $res = $this->getQueryBuilderProxy()
            ->field($field)
            ->condition([
                'id' => $post['id'],
                'status' => 1
            ])
            ->find();

        return $res;
    }

    /**
     * 缓存
     *
     * @param array $post
     * @return array
     */
    public function innerPanicCache(array $post): array
    {
        $key = 'panic_goods_' . $post['id'];

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->innerPanic($post);

        if (0 === count($data)) {
            return [];
        }

        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 30);

        return $data;
    }

    /**
     * 获取本周热门抢购
     *
     * @return array
     */
    public function getHotBuyThisWeek(): array
    {
        // 本周内的时间
        $time = time();

        // 获取今天是星期几
        $todayIsIt = date('w');

        // 结束时间
        $endTime = (7 - $todayIsIt) * 86400 + $time;

        // 开始时间
        $startTime = $time - ($todayIsIt - 1) * 86400;

        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where('status', 1)
            ->whereBetween('start_time', $startTime, $endTime)
            ->order('already_num', 'DESC')
            ->limit(6)
            ->select();
    }

    /**
     * 获取本周热门抢购（有缓存）
     *
     * @return array
     */
    public function getHotBuyThisWeekByCache(): array
    {
        $key = 'hot_buy_this_week_by_panic';

        $data = $this->cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getHotBuyThisWeek();
        if (0 === count($data)) {
            return [];
        }
        $this->cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 45);

        return $data;
    }
}