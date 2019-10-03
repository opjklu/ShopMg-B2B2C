<?php
namespace App\Models\Entity;

use Swoft\Db\Model;
use Swoft\Db\Bean\Annotation\Column;
use Swoft\Db\Bean\Annotation\Entity;
use Swoft\Db\Bean\Annotation\Id;
use Swoft\Db\Bean\Annotation\Required;
use Swoft\Db\Bean\Annotation\Table;
use Swoft\Db\Types;

/**
 * 积分订单商品表
 *
 * @Entity()
 * @Table(name="mg_order_integral_goods")
 * 
 * @uses DbOrderIntegralGoods
 */
class DbOrderIntegralGoods extends Model
{

    /**
     *
     * @var int $comment 是否已评价（0未评价1已评价）
     *      @Column(name="comment", type="tinyint", default=0)
     */
    private $comment;

    /**
     *
     * @var int $freightId 运费模板
     *      @Column(name="freight_id", type="integer", default=0)
     */
    private $freightId;

    /**
     *
     * @var int $goodsId 商品【编号】
     *      @Column(name="goods_id", type="integer")
     *      @Required()
     */
    private $goodsId;

    /**
     *
     * @var int $goodsNum 商品数量
     *      @Column(name="goods_num", type="integer")
     *      @Required()
     */
    private $goodsNum;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $integral 积分
     *      @Column(name="integral", type="integer")
     *      @Required()
     */
    private $integral;

    /**
     *
     * @var int $integralId 积分商品【编号】
     *      @Column(name="integral_id", type="integer", default=0)
     */
    private $integralId;

    /**
     *
     * @var float $money 商品价格
     *      @Column(name="money", type="decimal")
     *      @Required()
     */
    private $money;

    /**
     *
     * @var int $orderId 订单【编号】
     *      @Column(name="order_id", type="integer")
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var int $status -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $userId 用户【id】
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 是否已评价（0未评价1已评价）
     * 
     * @param int $value            
     * @return $this
     */
    public function setComment(int $value): self
    {
        $this->comment = $value;
        
        return $this;
    }

    /**
     * 运费模板
     * 
     * @param int $value            
     * @return $this
     */
    public function setFreightId(int $value): self
    {
        $this->freightId = $value;
        
        return $this;
    }

    /**
     * 商品【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsId(int $value): self
    {
        $this->goodsId = $value;
        
        return $this;
    }

    /**
     * 商品数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsNum(int $value): self
    {
        $this->goodsNum = $value;
        
        return $this;
    }

    /**
     * 编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setId(int $value)
    {
        $this->id = $value;
        
        return $this;
    }

    /**
     * 积分
     * 
     * @param int $value            
     * @return $this
     */
    public function setIntegral(int $value): self
    {
        $this->integral = $value;
        
        return $this;
    }

    /**
     * 积分商品【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIntegralId(int $value): self
    {
        $this->integralId = $value;
        
        return $this;
    }

    /**
     * 商品价格
     * 
     * @param float $value            
     * @return $this
     */
    public function setMoney(float $value): self
    {
        $this->money = $value;
        
        return $this;
    }

    /**
     * 订单【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderId(int $value): self
    {
        $this->orderId = $value;
        
        return $this;
    }

    /**
     * -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功
     * 
     * @param int $value            
     * @return $this
     */
    public function setStatus(int $value): self
    {
        $this->status = $value;
        
        return $this;
    }

    /**
     * 店铺【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreId(int $value): self
    {
        $this->storeId = $value;
        
        return $this;
    }

    /**
     * 用户【id】
     * 
     * @param int $value            
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->userId = $value;
        
        return $this;
    }

    /**
     * 是否已评价（0未评价1已评价）
     * 
     * @return int
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * 运费模板
     * 
     * @return int
     */
    public function getFreightId()
    {
        return $this->freightId;
    }

    /**
     * 商品【编号】
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 商品数量
     * 
     * @return int
     */
    public function getGoodsNum()
    {
        return $this->goodsNum;
    }

    /**
     * 编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 积分
     * 
     * @return int
     */
    public function getIntegral()
    {
        return $this->integral;
    }

    /**
     * 积分商品【编号】
     * 
     * @return int
     */
    public function getIntegralId()
    {
        return $this->integralId;
    }

    /**
     * 商品价格
     * 
     * @return float
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * 订单【编号】
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺【编号】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 用户【id】
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
