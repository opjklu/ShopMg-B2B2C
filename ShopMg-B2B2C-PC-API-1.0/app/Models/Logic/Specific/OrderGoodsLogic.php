<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderGoods;
use App\Common\TraitClass\OrderGoodsTrait;
use App\Models\Entity\DbOrderGoods;
use Common\Tool\Tool;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Cache\Cache;
use Tool\Db;
use Tool\SessionManager;

/**
 * 逻辑处理层
 *
 * @Bean()
 */
class OrderGoodsLogic extends AbstractLogic
{
    use OrderGoodsTrait;

    /**
     * 购物车编号
     *
     * @var string
     */
    private $cartId = [];

    /**
     * @Inject("cache")
     *
     * @var Cache
     */
    private $cache;

    /**
     *
     * @return string
     */
    public function getCartId(): array
    {
        $userId = session()->get('user_id');

        $cartId = $this->cartId[$userId];

        unset($this->cartId[$userId]);

        return $this->cartId;
    }


    public function __construct()
    {
        $this->tableName = DbOrderGoods::class;
    }

    /**
     * 返回验证数据
     */
    public function getValidateByLogin()
    {
        $message = [
            'price_sum' => [
                'required' => '订单总价必填'
            ],
            'address_id' => [
                'required' => '收货地址必填'
            ],
            'freight_id' => [
                'required' => '运费Id必填'
            ]
        ];
        return $message;
    }

    public function getValidateByOrder()
    {
        $message = [
            'id' => [
                'required' => '订单ID必须'
            ]
        ];
        return $message;
    }

    public function getValidateByCancel()
    {
    }

    
    public function getResult()
    {
       
    }
    
    /**
     * 修改订单商品状态(确认收货)
     * @param array $data
     * @return bool
     */
    public function confirmGetgoods(array $data): bool
    {
        $status = $this->getQueryBuilderProxy()
            ->where(OrderGoods::$orderId, $data['id'])
            ->where( OrderGoods::$userId, session()->get('user_id'))
            ->where(OrderGoods::$status, 3)
            ->save([
                OrderGoods::$status => 4
            ]);
        
        if (!$this->traceStation($status)) {
            $this->errorMessage = '确认收货失败';
            return false;
        }
        
        Db::commit();
        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return OrderGoods::class;
    }

    /**
     * 获取商品相关字段
     */
    public function getSplitKeyByGoods()
    {
        return OrderGoods::$goodsId;
    }

    /**
     * 生成订单商品
     */
    public function buildOrderGoods(array $orderData)
    {
        $status = $this->addAll($orderData);

        if (!$this->traceStation($status)) {
            $this->errorMessage .= '、由于长时间没有购买，缓存时间过期，请刷新重新购买。生成订单失败';
            return [];
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
        $cartInfo = SessionManager::GET_GOODS_DATA_SOURCE();

        if (empty($cartInfo)) {
            Db::rollback();
            return [];
        }

        $orderId = $post;

        $orderGoods = [];

        $i = 0;
        $cartIds = [];

        $userId = session()->get('user_id');

        foreach ($cartInfo as $key => $value) {

            $orderGoods[$i] = [];

            $orderGoods[$i][OrderGoods::$orderId] = $orderId[$value['store_id']]['order_id'];

            $orderGoods[$i][OrderGoods::$storeId] = $orderId[$value['store_id']]['store_id'];

            $orderGoods[$i][OrderGoods::$goodsNum] = $value['goods_num'];

            $orderGoods[$i][OrderGoods::$freightId] = $value['express_id'];

            $orderGoods[$i][OrderGoods::$goodsPrice] = $value['goods_price'];

            $orderGoods[$i][OrderGoods::$userId] = $userId;

            $orderGoods[$i][OrderGoods::$goodsId] = $value['goods_id'];

            $cartIds[$i] = $value['id'];

            $i++;
        }

        $this->cartId[$userId] = $cartIds;

        return $orderGoods;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $goods = SessionManager::GET_GOODS_DATA_SOURCE();

        $orderGoods = [];

        $orderGoods[OrderGoods::$orderId] = $insert['order_id'];

        $orderGoods[OrderGoods::$storeId] = $goods['store_id'];

        $orderGoods[OrderGoods::$goodsNum] = $goods['goods_num'];

        $orderGoods[OrderGoods::$freightId] = $goods['express_id'];

        $orderGoods[OrderGoods::$goodsPrice] = $goods['goods_price'];

        $orderGoods[OrderGoods::$userId] = session()->get('user_id');

        $orderGoods[OrderGoods::$status] = '0';

        $orderGoods[OrderGoods::$goodsId] = $goods['goods_id'];

        return $orderGoods;
    }

    /**
     * 生成订单商品->立即购买
     */
    public function placeTheOrderGoods(array $order): bool
    {
        $status = $this->addData($order);

        if (!$this->traceStation($status)) {
            $this->errorMessage .= '、由于长时间没有购买，缓存时间过期，请刷新重新购买。生成订单失败';
            return false;
        }

        return true;
    }

    /**
     * 更新订单商品状态
     */
    public function updateOrderGoodsStatus(array $ids): bool
    {
        $status = $this->getQueryBuilderProxy()
            ->whereIn(OrderGoods::$orderId, $ids)
            ->save([
                OrderGoods::$status => 1
            ]);
        return $this->traceStation($status);
    }

    /**
     * 修改订单商品状态
     */
    public function returnAuditStatus(array $data): bool
    {
        return $this->getQueryBuilderProxy()
            ->where(OrderGoods::$orderId, $data['order_id'])
            ->where( OrderGoods::$goodsId, $data['goods_id'])
            ->where(OrderGoods::$userId, session()->get('user_id'))
            ->save([
                OrderGoods::$status => 5
            ]);
    }

    public function returnAuditStatusByTrancestation(array $post): bool
    {
        try {

            $status = $this->returnAuditStatus($post);

            if (!$this->traceStation($status)) {
                $this->errorMessage = '申请售后订单修改状态失败';
                return false;
            }

            Db::commit();

            return true;
        } catch (\Exception $e) {

            Db::rollback();
            
            $this->errorMessage = $e->getMessage();

            return false;
        }
    }

    /**
     * 普通订单退换货
     *
     * @return boolean
     */
    public function updateExchangeGoodsStatus(array $data): bool
    {
        $rest = $this->getQueryBuilderProxy()
            ->condition([
                'order_id' => $data['order_id'],
                "goods_id" => $data['goods_id']
            ])
            ->save([
                'status' => 5
            ]);

        if (!$this->traceStation($rest)) {
            return false;
        }

        Db::commit();

        return true;
    }

    /**
     * 根据订单信息查询订单商品信息list
     */
    public function getOrderGoodsByInfo(array $data, string $splitKey): array
    {
        $orderId = array_column($data, $splitKey);

        $field = [
            OrderGoods::$orderId,
            OrderGoods::$goodsId,
            OrderGoods::$goodsPrice,
            OrderGoods::$storeId,
            OrderGoods::$status,
            OrderGoods::$goodsNum
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->whereIn(OrderGoods::$orderId, $orderId)
            ->where('user_id', session()->get('user_id'))
            ->select();
    }

    /**
     * 根据订单信息查询订单商品信息（单条数据）
     */
    public function getOrderGoodsById(array $data): array
    {
        $field = [
            OrderGoods::$orderId,
            OrderGoods::$goodsId,
            OrderGoods::$goodsPrice,
            OrderGoods::$storeId,
            OrderGoods::$status
        ];

        return $this->getQueryBuilderProxy()
            ->field($field)
            ->where(OrderGoods::$orderId, $data['id'])
            ->where('user_id', session()->get('user_id'))
            ->select();
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
                'status' => 10
            ]);

        if (!$this->traceStation($rest)) {
            return false;
        }

        Db::commit();

        return true;
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
                OrderGoods::$status => 4
            ]);

        if (!$this->traceStation($status)) {
            $this->errorMessage = '订单商品签收失败';
            return false;
        }

        Db::commit();

        return true;
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
            OrderGoods::$id,
            OrderGoods::$goodsId,
            OrderGoods::$goodsNum,
            OrderGoods::$goodsPrice,
            OrderGoods::$storeId,
            OrderGoods::$status,
            OrderGoods::$orderId
        ];
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
                'user_id' => $userId
            ])
            ->find();

        if (0 === count($data)) {
            $this->errorMessage = '找不到退货商品信息';
            return [];
        }

        $key = $userId . '_order_goods_return11111';

        $this->cache->set($key, json_encode($data), 90);

        return $data;
    }

    /**
     *
     * @return string
     */
    public function getSplitKeyByStore(): string
    {
        return OrderGoods::$storeId;
    }

    /**
     * 取消订单
     *
     * @return bool
     */
    public function cancelOrderGooods(array $data): bool
    {
        $status = $this->getQueryBuilderProxy()
            ->where(OrderGoods::$orderId, $data['id'])
            ->where(OrderGoods::$userId, session()->get('user_id'))
            ->save([
                OrderGoods::$status => -1
            ]);

        if (!$this->traceStation($status)) {
            return false;
        }
        Db::commit();

        return true;
    }

    /**
     * 删除订单商品
     *
     * @return bool
     */
    public function deleteOrderGooods(array $data): bool
    {
        $status = $this->getQueryBuilderProxy()
            ->where(OrderGoods::$orderId, $data['id'])
            ->whereBetween(OrderGoods::$status, -1, 0)
            ->where(OrderGoods::$userId, session()->get('user_id'))
            ->delete();

        if (!$this->traceStation($status)) {
            return false;
        }

        Db::commit();

        return true;
    }
}
