<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\OrderIntegralGoods;
use App\Common\TraitClass\OrderGoodsTrait;
use App\Models\Entity\DbOrderIntegralGoods;
use Common\SessionParse\SessionManager;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\Db;

/**
 *
 * @author wq
 *
 * @Bean()
 */
class OrderIntegralGoodsLogic extends AbstractLogic
{
    use OrderGoodsTrait;

    /**
     * 返回客户端数据
     *
     * @var array
     */
    private $clientDataReturn = [];

    /**
     */
    public function getClientDataReturn()
    {
        return $this->clientDataReturn;
    }


    public function __construct()
    {
        $this->tableName = DbOrderIntegralGoods::class;
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
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return OrderIntegralGoods::class;
    }

    /**
     * add 积分商品
     */
    public function addOrderIntegral(array $data): bool
    {
        $status = $this->addData($data);

        if (!$this->traceStation($status)) {
            return false;
        }

        $this->getQueryBuilderProxy()->commit();

        return true;
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

        $goodData = [];
        // 创建订单成功以后 将订单商品信息加入订单商品表
        $goodData[OrderIntegralGoods::$orderId] = $insert['integral_order_id'];
        $goodData[OrderIntegralGoods::$goodsId] = $goods['goods_id'];
        $goodData[OrderIntegralGoods::$goodsNum] = $goods['goods_num'];
        $goodData[OrderIntegralGoods::$integral] = $goods['every_integral'];
        $goodData[OrderIntegralGoods::$money] = $goods['goods_price'];
        $goodData[OrderIntegralGoods::$status] = 0;
        $goodData[OrderIntegralGoods::$storeId] = $goods['store_id'];
        $goodData[OrderIntegralGoods::$comment] = 0;
        $goodData[OrderIntegralGoods::$userId] = session()->get('user_id');
        $goodData[OrderIntegralGoods::$freightId] = $goods['express_id'];

        return $goodData;
    }

    /**
     * 更新订单商品状态
     */
    public function updateOrderGoodsStatus(array $orderId): bool
    {


        $status = $this->getQueryBuilderProxy()
            ->whereIn(OrderIntegralGoods::$orderId, $orderId)
            ->save([
                OrderIntegralGoods::$status => 1
            ]);
        return $this->traceStation($status);
    }

    /**
     * 后期优化
     */
    public function getOrderGoodsByInfo(array $data, string $splitKey): array
    {
        $orderId = array_column($data, $splitKey);

        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->whereIn(OrderIntegralGoods::$orderId, $orderId)
            ->where('user_id', session()->get('user_id'))
            ->select();
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
            OrderIntegralGoods::$id,
            OrderIntegralGoods::$freightId,
            OrderIntegralGoods::$goodsNum,
            OrderIntegralGoods::$integral,
            OrderIntegralGoods::$integralId,
            OrderIntegralGoods::$status,
            OrderIntegralGoods::$orderId,
            OrderIntegralGoods::$storeId,
            OrderIntegralGoods::$goodsId
        ];
    }

    /**
     * 根据id获取积分商品
     *
     * @return array
     */
    public function getOrderGoodsById(array $data): array
    {
        return $this->getQueryBuilderProxy()
            ->field($this->getTableColum())
            ->where(OrderIntegralGoods::$orderId, $data['id'])
            ->where(OrderIntegralGoods::$userId, session()->get('user_id'))
            ->select();
    }

    protected function getCoulmByPay(): array
    {
        return [
            OrderIntegralGoods::$goodsNum,
            OrderIntegralGoods::$money . ' as goods_price',
            OrderIntegralGoods::$goodsId
        ];
    }

    /**
     * 商品相关key
     *
     * @return string
     */
    public function getSplitKeyByGoods(): string
    {
        return OrderIntegralGoods::$goodsId;
    }

    /**
     * 店铺关联数据
     *
     * @return string
     */
    public function getSplitStore(): string
    {
        return OrderIntegralGoods::$storeId;
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
                'user_id' => session()->get('user_id')
            ])
            ->save([
                OrderIntegralGoods::$status => 4
            ]);

        if (!$this->traceStation($status)) {
            return false;
        }
        Db::commit();
        return true;
    }
}