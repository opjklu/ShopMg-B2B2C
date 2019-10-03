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
 * 开店订单
 *
 * @Entity()
 * @Table(name="mg_open_shop_order")
 * 
 * @uses DbOpenShopOrder
 */
class DbOpenShopOrder extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $orderSn 订单标志
     *      @Column(name="order_sn", type="string", length=50)
     *      @Required()
     */
    private $orderSn;

    /**
     *
     * @var int $orderStatus 支付状态 【0 未支付 1已支付】
     *      @Column(name="order_status", type="tinyint", default=0)
     */
    private $orderStatus;

    /**
     *
     * @var int $payPlatform 支付平台【 0pc 1 wap 2 app， 3微商城】
     *      @Column(name="pay_platform", type="tinyint", default=1)
     */
    private $payPlatform;

    /**
     *
     * @var int $payTime 支付时间
     *      @Column(name="pay_time", type="bigint", default=0)
     */
    private $payTime;

    /**
     *
     * @var int $payType 支付类型
     *      @Column(name="pay_type", type="tinyint", default=0)
     */
    private $payType;

    /**
     *
     * @var int $storeId 店铺
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     *
     * @var int $type 类型【0个人入住1 企业入住】
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var int $userId 用户
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 创建时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setCreateTime(int $value): self
    {
        $this->createTime = $value;
        
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
     * 订单标志
     * 
     * @param string $value            
     * @return $this
     */
    public function setOrderSn(string $value): self
    {
        $this->orderSn = $value;
        
        return $this;
    }

    /**
     * 支付状态 【0 未支付 1已支付】
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderStatus(int $value): self
    {
        $this->orderStatus = $value;
        
        return $this;
    }

    /**
     * 支付平台【 0pc 1 wap 2 app， 3微商城】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPayPlatform(int $value): self
    {
        $this->payPlatform = $value;
        
        return $this;
    }

    /**
     * 支付时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setPayTime(int $value): self
    {
        $this->payTime = $value;
        
        return $this;
    }

    /**
     * 支付类型
     * 
     * @param int $value            
     * @return $this
     */
    public function setPayType(int $value): self
    {
        $this->payType = $value;
        
        return $this;
    }

    /**
     * 店铺
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
     * 类型【0个人入住1 企业入住】
     * 
     * @param int $value            
     * @return $this
     */
    public function setType(int $value): self
    {
        $this->type = $value;
        
        return $this;
    }

    /**
     * 用户
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
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
     * 订单标志
     * 
     * @return string
     */
    public function getOrderSn()
    {
        return $this->orderSn;
    }

    /**
     * 支付状态 【0 未支付 1已支付】
     * 
     * @return int
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * 支付平台【 0pc 1 wap 2 app， 3微商城】
     * 
     * @return mixed
     */
    public function getPayPlatform()
    {
        return $this->payPlatform;
    }

    /**
     * 支付时间
     * 
     * @return int
     */
    public function getPayTime()
    {
        return $this->payTime;
    }

    /**
     * 支付类型
     * 
     * @return int
     */
    public function getPayType()
    {
        return $this->payType;
    }

    /**
     * 店铺
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 类型【0个人入住1 企业入住】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 用户
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
