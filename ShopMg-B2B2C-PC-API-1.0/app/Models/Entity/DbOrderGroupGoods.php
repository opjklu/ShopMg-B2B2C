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
 * 团购订单商品表
 *
 * @Entity()
 * @Table(name="mg_order_group_goods")
 * 
 * @uses DbOrderGroupGoods
 */
class DbOrderGroupGoods extends Model
{

    /**
     *
     * @var int $addTime 添加时间
     *      @Column(name="add_time", type="integer")
     *      @Required()
     */
    private $addTime;

    /**
     *
     * @var int $editTime 修改时间
     *      @Column(name="edit_time", type="integer")
     *      @Required()
     */
    private $editTime;

    /**
     *
     * @var int $goodsId 商品id
     *      @Column(name="goods_id", type="integer")
     *      @Required()
     */
    private $goodsId;

    /**
     *
     * @var int $goodsNum 商品数量
     *      @Column(name="goods_num", type="integer", default=0)
     */
    private $goodsNum;

    /**
     *
     * @var float $goodsPrice 商品单价
     *      @Column(name="goods_price", type="float")
     *      @Required()
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
     * @var int $orderId 订单id
     *      @Column(name="order_id", type="integer")
     *      @Required()
     */
    private $orderId;

    /**
     * 添加时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setAddTime(int $value): self
    {
        $this->addTime = $value;
        
        return $this;
    }

    /**
     * 修改时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setEditTime(int $value): self
    {
        $this->editTime = $value;
        
        return $this;
    }

    /**
     * 商品id
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
     * 商品单价
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
     * 订单id
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
     * 添加时间
     * 
     * @return int
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * 修改时间
     * 
     * @return int
     */
    public function getEditTime()
    {
        return $this->editTime;
    }

    /**
     * 商品id
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
     * 商品单价
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
     * 订单id
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
}
