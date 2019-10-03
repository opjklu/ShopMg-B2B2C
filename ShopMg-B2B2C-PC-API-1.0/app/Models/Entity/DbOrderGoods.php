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
 * 订单商品表
 *
 * @Entity()
 * @Table(name="mg_order_goods")
 * 
 * @uses DbOrderGoods
 */
class DbOrderGoods extends Model
{

    /**
     *
     * @var int $comment 是否已评价（0未评价1已评价）
     *      @Column(name="comment", type="tinyint", default=0)
     */
    private $comment;

    /**
     *
     * @var int $freightId 模板【编号】
     *      @Column(name="freight_id", type="integer")
     *      @Required()
     */
    private $freightId;

    /**
     *
     * @var int $goodsId 商品编号
     *      @Column(name="goods_id", type="integer", default=0)
     */
    private $goodsId;

    /**
     *
     * @var int $goodsNum 商品数量
     *      @Column(name="goods_num", type="integer")
     */
    private $goodsNum;

    /**
     *
     * @var float $goodsPrice 商品价格
     *      @Column(name="goods_price", type="float")
     */
    private $goodsPrice;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderId 商品id
     *      @Column(name="order_id", type="integer", default=0)
     */
    private $orderId;

    /**
     *
     * @var int $over 是否已完成该单(0未完成 1已完成）
     *      @Column(name="over", type="tinyint", default=0)
     */
    private $over;

    /**
     *
     * @var int $spaceId 商品规格id
     *      @Column(name="space_id", type="integer")
     */
    private $spaceId;

    /**
     *
     * @var int $status -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功, 10退货商家收货中，11退货商家已收货，12换货审核中
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
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     *
     * @var int $wareId 所在仓库
     *      @Column(name="ware_id", type="integer")
     */
    private $wareId;

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
     * 模板【编号】
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
     * 商品编号
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
     * 商品价格
     * 
     * @param float $value            
     * @return $this
     */
    public function setGoodsPrice(float $value): self
    {
        $this->goodsPrice = $value;
        
        return $this;
    }

    /**
     * id
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
     * 商品id
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
     * 是否已完成该单(0未完成 1已完成）
     * 
     * @param int $value            
     * @return $this
     */
    public function setOver(int $value): self
    {
        $this->over = $value;
        
        return $this;
    }

    /**
     * 商品规格id
     * 
     * @param int $value            
     * @return $this
     */
    public function setSpaceId(int $value): self
    {
        $this->spaceId = $value;
        
        return $this;
    }

    /**
     * -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功, 10退货商家收货中，11退货商家已收货，12换货审核中
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
     * 用户id
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
     * 所在仓库
     * 
     * @param int $value            
     * @return $this
     */
    public function setWareId(int $value): self
    {
        $this->wareId = $value;
        
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
     * 模板【编号】
     * 
     * @return int
     */
    public function getFreightId()
    {
        return $this->freightId;
    }

    /**
     * 商品编号
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
     * 商品价格
     * 
     * @return float
     */
    public function getGoodsPrice()
    {
        return $this->goodsPrice;
    }

    /**
     * id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 商品id
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 是否已完成该单(0未完成 1已完成）
     * 
     * @return int
     */
    public function getOver()
    {
        return $this->over;
    }

    /**
     * 商品规格id
     * 
     * @return int
     */
    public function getSpaceId()
    {
        return $this->spaceId;
    }

    /**
     * -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功, 10退货商家收货中，11退货商家已收货，12换货审核中
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
     * 用户id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 所在仓库
     * 
     * @return int
     */
    public function getWareId()
    {
        return $this->wareId;
    }
}
