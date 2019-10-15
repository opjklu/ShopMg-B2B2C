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
 * 抢购立即购买
 *
 * @author wq
 * @Bean()
 */
class PanicBuyLogic extends AbstractLogic
{

    /**
     * @Inject()
     *
     * @var Redis
     */
    private $cache;

    /**
     *
     * @return the $cache
     */
    public function getCache()
    {
        return $this->cache;
    }


    public function __construct()
    {
        $this->tableName = DbPanic::class;
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
        return Panic::class;
    }

    /**
     * 验证消息
     *
     * @return array
     */
    public function getVlidateMsg(): array
    {
        return [
            'id' => [
                'number' => '商品Id参数必须'
            ],
            'goods_num' => [
                'number' => '商品数量参数必须'
            ]
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
            Panic::$id,
            Panic::$alreadyNum,
            Panic::$goodsId,
            Panic::$endTime,
            Panic::$panicNum,
            Panic::$panicPrice,
            Panic::$panicTitle,
            Panic::$startTime,
            Panic::$status,
            Panic::$storeId
        ];
    }

    /**
     * 获取抢购详情
     *
     * @return array
     */
    public function getPanicDetailByOrder(array $post): array
    {
        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                'id' => $post['id'],
                Panic::$status => 1
            ])
            ->bind([
                [
                    ':id',
                    $post['id'],
                    \PDO::PARAM_INT
                ]
            ])
            ->find();
        return $data;
    }

    /**
     * 获取抢购详情
     *
     * @return array
     */
    public function getPanicDetailByOrderCache(array $post): array
    {
        $key = 'panic_goods_' . $post['id'];

        $cache = &$this->cache;

        $data = $cache->get($key);

        if ($data) {
            return json_decode($data, true);
        }

        $data = $this->getPanicDetailByOrder($post);

        if (empty($data)) {
            return [];
        }

        $cache->set($key, json_encode($data, JSON_UNESCAPED_UNICODE), 30);

        return $data;
    }

    /**
     * 购买之前返回数据
     *
     * @return array
     */
    public function beforeImmediatelyBuy(array $post): array
    {
        if (!$this->beforeBuy($post)) {

            return [];
        }

        return $this->getPanicDetailByOrderCache($post);
    }

    /**
     * 购买前处理
     */
    private function beforeBuy(array $post): bool
    {
        $cache = &$this->cache;

        $key = 'panic_key_zh' . $post['id'];

        $quantityLimit = $cache->get($key);

        if (!$quantityLimit) {
            $this->errorMessage = '未找到抢购信息';
            return false;
        }

        $num = (int)$post['goods_num'];

        if ($quantityLimit < $num) {

            $this->errorMessage = '每个人最多可购买' . $quantityLimit . '件';

            return false;
        }

        $userStockKey = $post['id'] . '_panic_user_key';

        $goodsStoreKey = 'goods_store_panic' . $post['id'];

        $handler = &$this->cache;

        $userId = session()->get('user_id');

        $number = $handler->lLen($goodsStoreKey);

        if ($number <= 0) {

            $this->errorMessage = '已抢光';

            // 清空用户哈希
            $handler->delete($userStockKey);

            return false;
        }

        $stock = 0;

        // 判断是否购买过
        if (!$handler->hGet($userStockKey, $userId)) {

            $stock = $handler->lPop($goodsStoreKey);

            if ($stock <= 0) {
                $this->errorMessage = '库存不足';

                return false;
            }
        }

        if ($stock > $num) {
            // 购买数量小于队列数量 重新添加添加到队尾
            $handler->rpush($goodsStoreKey, ($stock - $post['goods_num']));
        }

        // 当前用户是否已购买过
        if (!$handler->hGet($userStockKey, $userId)) {
            // 插入抢购用户信息
            $userinfo = array(
                "user_id" => $userId,
                "create_time" => time()
            );
            $handler->hSet($userStockKey, $userId, serialize($userinfo));
        } else {
            $this->errorMessage = '该用户已购买过';

            return false;
        }
        return true;
    }

    /**
     * 获取商品分割key
     *
     * @return string
     */
    public function getGoodsBySplitKey(): string
    {
        return Panic::$goodsId;
    }
}