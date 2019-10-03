<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderPackageGoods;
use App\Common\TraitClass\OrderGoodsTrait;
use App\Models\Entity\DbOrderPackageGoods;
use Common\SessionParse\SessionManager;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\Db;

/**
 * 优惠套餐逻辑处理类
 *
 * @author Administrator
 *
 * @Bean()
 */
class OrderPackageGoodsLogic extends AbstractLogic
{
    use OrderGoodsTrait;

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;


    public function __construct()
    {
        $this->tableName = DbOrderPackageGoods::class;
    }

    /**
     * 获取结果（订单商品）
     */
    public function getResult()
    {

    }

    /**
     * 生成订单商品
     * @param array $orderData
     * @return bool
     */
    public function buildOrderGoods(array $orderData): bool
    {
        $status = $this->addAll($orderData);

        if (!$this->traceStation($status)) {
            return false;
        }

        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAddAll()
     */
    protected function getParseResultByAddAll(array $post): array
    {
        $packageSub = SessionManager::GET_GOODS_DATA_SOURCE();

        $i = 0;
        $time = time();

        $orderIdArray = &$post;

        $orderGoodsData = [];

        foreach ($packageSub as $key => $value) {

            $orderGoodsData[$i] = [];

            $orderGoodsData[$i][OrderPackageGoods::$orderId] = $orderIdArray[$value['store_id']]['order_id'];
            $orderGoodsData[$i][OrderPackageGoods::$packageId] = $value['package_id'];
            $orderGoodsData[$i][OrderPackageGoods::$packageNum] = $value['goods_num'];
            $orderGoodsData[$i][OrderPackageGoods::$packageTotal] = $value['package_total'];
            $orderGoodsData[$i][OrderPackageGoods::$packageDiscount] = $value['package_discount'];
            $orderGoodsData[$i][OrderPackageGoods::$goodsId] = $value['goods_id'];
            $orderGoodsData[$i][OrderPackageGoods::$goodsDiscount] = $value['goods_price'];
            $orderGoodsData[$i][OrderPackageGoods::$status] = '0';
            $orderGoodsData[$i][OrderPackageGoods::$createTime] = $time;
            $orderGoodsData[$i][OrderPackageGoods::$userId] = session()->get('user_id');
            $orderGoodsData[$i][OrderPackageGoods::$updateTime] = $time;
            $orderGoodsData[$i][OrderPackageGoods::$freightId] = $value['express_id'];
            $orderGoodsData[$i][OrderPackageGoods::$storeId] = $value['store_id'];

            $i++;
        }

        return $orderGoodsData;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return OrderPackageGoods::class;
    }

    /**
     * 获取套餐订单商品
     *
     * @return array
     */
    public function getPackageOrderGoodsInfo(array $data, string $splitKey): array
    {
        $ids = array_column($data, $splitKey);

        $field = $this->getTableColum();

        $orderPackageGoods = $this->getQueryBuilderProxy()
            ->field($field)
            ->where(OrderPackageGoods::$orderId, $ids)
            ->select();

        if (count($orderPackageGoods) === 0) {
            $this->errorMessage = '订单错误';
            return [];
        }

        return $orderPackageGoods;
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
            OrderPackageGoods::$packageId,
            OrderPackageGoods::$packageNum,
            OrderPackageGoods::$packageTotal,
            OrderPackageGoods::$packageDiscount,
            OrderPackageGoods::$goodsDiscount,
            OrderPackageGoods::$goodsId,
            OrderPackageGoods::$orderId,
            OrderPackageGoods::$status,
            OrderPackageGoods::$freightId,
            OrderPackageGoods::$storeId
        ];
    }

    /**
     *
     * @return string
     */
    public function getSplitKeyByGoods(): string
    {
        return OrderPackageGoods::$goodsId;
    }

    /**
     * 根据订单id获取商品相关
     */
    public function getOrderGoodsById(array $data): array
    {
        $field = $this->getTableColum();

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where(OrderPackageGoods::$orderId, $data['id'])
            ->select();
    }

    /**
     * 根据订单id及其商品id获取订单商品数据
     *
     * @return array
     */
    public function getOrderPackageGoodsInfoByOAndGId(array $post): array
    {
        $userId = session()->get('user_id');

        $data = $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->condition([
                'order_id' => $post['order_id'],
                'goods_id' => $post['goods_id'],
                'user_id' => $userId,
                'package_id' => $post['package_id']
            ])
            ->find();

        if (empty($data)) {
            $this->errorMessage = '找不到退货商品信息';
            return [];
        }

        $key = $userId . '_order_package_goods_return';

        $this->cache->set($key, json_encode($data), 90);

        return $data;
    }

    /**
     * 套餐换货 修改状态
     */
    public function updateExchangeGoodsStatus(array $data): bool
    {
        $rest = $this->getQueryBuilderProxy()
            ->condition([
                'order_id' => $data['order_id'],
                "goods_id" => $data['goods_id']
            ])
            ->save([
                'status' => 5,
                'update_time' => time()
            ]);

        if (!$this->traceStation($rest)) {
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 套餐退货 修改状态
     */
    public function updateReturnGoodsStatus(array $data): bool
    {
        $rest = $this->getQueryBuilderProxy()
            ->condition([
                'order_id' => $data['order_id'],
                "goods_id" => $data['goods_id'],
                'package_id' => $data['package_id'],
                'user_id' => session()->get('user_id')
            ])
            ->save([
                'status' => 5
            ]);

        if (!$this->traceStation($rest)) {
            return false;
        }

        $this->getQueryBuilderProxy()->commit();

        return true;
    }

    /**
     * 普通订单退换货
     *
     * @return boolean
     */
    public function updateRetuernGoodsReceiveStatus(array $data): bool
    {
        $rest = $this->getQueryBuilderProxy()
            ->condition([
                'order_id' => $data['order_id'],
                "goods_id" => $data['goods_id']
            ])
            ->save([
                'status' => 10,
                'update_time' => time()
            ]);

        if (!$this->traceStation($rest)) {
            return false;
        }

        Db::commit();

        return true;
    }

    protected function getCoulmByPay(): array
    {
        return [
            OrderPackageGoods::$packageNum . ' as goods_num',
            OrderPackageGoods::$packageDiscount . ' as goods_price',
            OrderPackageGoods::$goodsId
        ];
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMessageNotice()
     */
    public function getMessageNotice(): array
    {
        return [
            OrderPackageGoods::$orderId => [
                'number' => '订单编号必须是数字'
            ],
            OrderPackageGoods::$goodsId => [
                'number' => '商品编号必须是数字'
            ],

            OrderPackageGoods::$packageId => [
                'number' => '商品套餐编号必须是数字'
            ]
        ];
    }

    /**
     *
     * @return array
     */
    public function getSplitKeyByStore(): string
    {
        return OrderPackageGoods::$storeId;
    }

    /**
     * 订单商品签收
     *
     * @return array
     */
    public function setOrderOverTime(array $post): bool
    {
        $status = $this->getQueryBuilderProxy()
            ->condition([
                'order_id' => $post['id'],
                ':u_id' => session()->get('user_id')
            ])
            ->save([
                OrderPackageGoods::$status => 4
            ]);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '订单商品签收失败';
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByApply(): array
    {
        return [
            'order_id' => [
                'number' => '订单ID必填'
            ],
            'goods_id' => [
                'number' => '商品ID必填'
            ],
            'explain' => [
                'required' => '申请理由说明必填'
            ],
            'apply_img' => [
                'required' => '申请图片必填'
            ],
            'store_id' => [
                'number' => '店铺ID必填'
            ],

            'package_id' => [
                'number' => '套餐编号必须传递'
            ]
        ];
    }

    /**
     * 修改订单商品状态(确认收货)
     */
    public function confirmGet(array $post)
    {
        $status = $this->getQueryBuilderProxy()
            ->where(OrderPackageGoods::$orderId, $post['id'])
            ->where(OrderPackageGoods::$userId, session()->get('user_id'))
            ->where(OrderPackageGoods::$status, 3)
            ->save([
                OrderPackageGoods::$status => 4
            ]);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '确认收货失败';
            return false;
        }
        Db::commit();
        return true;
    }
}