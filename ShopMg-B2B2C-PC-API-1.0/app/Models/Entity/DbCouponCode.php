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
 * 团购订单--领券码表
 *
 * @Entity()
 * @Table(name="mg_coupon_code")
 * 
 * @uses DbCouponCode
 */
class DbCouponCode extends Model
{

    /**
     *
     * @var string $couponCode 领券码
     *      @Column(name="coupon_code", type="string", length=50)
     *      @Required()
     */
    private $couponCode;

    /**
     *
     * @var int $goodsId 商品id
     *      @Column(name="goods_id", type="integer")
     */
    private $goodsId;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderId 团购订单编号
     *      @Column(name="order_id", type="integer")
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var int $receiveTime 领取时间
     *      @Column(name="receive_time", type="integer")
     */
    private $receiveTime;

    /**
     *
     * @var int $status 是否领取0未领取1已领取
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 领券码
     * 
     * @param string $value            
     * @return $this
     */
    public function setCouponCode(string $value): self
    {
        $this->couponCode = $value;
        
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
     * 团购订单编号
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
     * 领取时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setReceiveTime(int $value): self
    {
        $this->receiveTime = $value;
        
        return $this;
    }

    /**
     * 是否领取0未领取1已领取
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
     * 领券码
     * 
     * @return string
     */
    public function getCouponCode()
    {
        return $this->couponCode;
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
     * id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 团购订单编号
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 领取时间
     * 
     * @return int
     */
    public function getReceiveTime()
    {
        return $this->receiveTime;
    }

    /**
     * 是否领取0未领取1已领取
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
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
}
