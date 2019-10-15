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
 * 套餐订单表
 *
 * @Entity()
 * @Table(name="mg_order_package")
 * 
 * @uses DbOrderPackage
 */
class DbOrderPackage extends Model
{

    /**
     *
     * @var int $addressId 收货地址编号
     *      @Column(name="address_id", type="integer")
     */
    private $addressId;

    /**
     *
     * @var int $commentStatus 评价状态 0未评价 1已评价
     *      @Column(name="comment_status", type="tinyint")
     */
    private $commentStatus;

    /**
     *
     * @var float $couponDeductible 优惠券抵扣金额
     *      @Column(name="coupon_deductible", type="decimal")
     */
    private $couponDeductible;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $deliveryTime 发货时间
     *      @Column(name="delivery_time", type="integer")
     */
    private $deliveryTime;

    /**
     *
     * @var int $expId 快递表编号
     *      @Column(name="exp_id", type="integer", default=0)
     */
    private $expId;

    /**
     *
     * @var int $expressId 快递单编号
     *      @Column(name="express_id", type="bigint")
     */
    private $expressId;

    /**
     *
     * @var int $id 套餐订单表id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $orderSnId 订单标识
     *      @Column(name="order_sn_id", type="string", length=50)
     */
    private $orderSnId;

    /**
     *
     * @var int $orderStatus -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功,
     *      @Column(name="order_status", type="tinyint")
     */
    private $orderStatus;

    /**
     *
     * @var int $overTime 完结时间
     *      @Column(name="over_time", type="integer")
     */
    private $overTime;

    /**
     *
     * @var int $payTime 支付时间
     *      @Column(name="pay_time", type="integer")
     */
    private $payTime;

    /**
     *
     * @var int $payType 支付类型编号
     *      @Column(name="pay_type", type="integer")
     */
    private $payType;

    /**
     *
     * @var int $platform 平台[：0代表pc，1代表app 2 wap, 3微商城]
     *      @Column(name="platform", type="tinyint")
     */
    private $platform;

    /**
     *
     * @var float $priceSum 订单总价
     *      @Column(name="price_sum", type="float")
     */
    private $priceSum;

    /**
     *
     * @var string $remarks 订单备注
     *      @Column(name="remarks", type="string", length=150)
     */
    private $remarks;

    /**
     *
     * @var float $shippingMonery 运费【这样 就不用 重复计算两遍】
     *      @Column(name="shipping_monery", type="decimal", default=0)
     */
    private $shippingMonery;

    /**
     *
     * @var int $status 0正常1删除
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺编号
     *      @Column(name="store_id", type="integer")
     */
    private $storeId;

    /**
     *
     * @var int $translate 是否需要发票【0不需要， 1要】
     *      @Column(name="translate", type="tinyint", default=0)
     */
    private $translate;

    /**
     *
     * @var int $userId 用户编号
     *      @Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * 收货地址编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setAddressId(int $value): self
    {
        $this->addressId = $value;
        
        return $this;
    }

    /**
     * 评价状态 0未评价 1已评价
     * 
     * @param int $value            
     * @return $this
     */
    public function setCommentStatus(int $value): self
    {
        $this->commentStatus = $value;
        
        return $this;
    }

    /**
     * 优惠券抵扣金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setCouponDeductible(float $value): self
    {
        $this->couponDeductible = $value;
        
        return $this;
    }

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
     * 发货时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setDeliveryTime(int $value): self
    {
        $this->deliveryTime = $value;
        
        return $this;
    }

    /**
     * 快递表编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setExpId(int $value): self
    {
        $this->expId = $value;
        
        return $this;
    }

    /**
     * 快递单编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setExpressId(int $value): self
    {
        $this->expressId = $value;
        
        return $this;
    }

    /**
     * 套餐订单表id
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
     * 订单标识
     * 
     * @param string $value            
     * @return $this
     */
    public function setOrderSnId(string $value): self
    {
        $this->orderSnId = $value;
        
        return $this;
    }

    /**
     * -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功,
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
     * 完结时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setOverTime(int $value): self
    {
        $this->overTime = $value;
        
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
     * 支付类型编号
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
     * 平台[：0代表pc，1代表app 2 wap, 3微商城]
     * 
     * @param int $value            
     * @return $this
     */
    public function setPlatform(int $value): self
    {
        $this->platform = $value;
        
        return $this;
    }

    /**
     * 订单总价
     * 
     * @param float $value            
     * @return $this
     */
    public function setPriceSum(float $value): self
    {
        $this->priceSum = $value;
        
        return $this;
    }

    /**
     * 订单备注
     * 
     * @param string $value            
     * @return $this
     */
    public function setRemarks(string $value): self
    {
        $this->remarks = $value;
        
        return $this;
    }

    /**
     * 运费【这样 就不用 重复计算两遍】
     * 
     * @param float $value            
     * @return $this
     */
    public function setShippingMonery(float $value): self
    {
        $this->shippingMonery = $value;
        
        return $this;
    }

    /**
     * 0正常1删除
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
     * 店铺编号
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
     * 是否需要发票【0不需要， 1要】
     * 
     * @param int $value            
     * @return $this
     */
    public function setTranslate(int $value): self
    {
        $this->translate = $value;
        
        return $this;
    }

    /**
     * 用户编号
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
     * 收货地址编号
     * 
     * @return int
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * 评价状态 0未评价 1已评价
     * 
     * @return int
     */
    public function getCommentStatus()
    {
        return $this->commentStatus;
    }

    /**
     * 优惠券抵扣金额
     * 
     * @return float
     */
    public function getCouponDeductible()
    {
        return $this->couponDeductible;
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
     * 发货时间
     * 
     * @return int
     */
    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    /**
     * 快递表编号
     * 
     * @return int
     */
    public function getExpId()
    {
        return $this->expId;
    }

    /**
     * 快递单编号
     * 
     * @return int
     */
    public function getExpressId()
    {
        return $this->expressId;
    }

    /**
     * 套餐订单表id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 订单标识
     * 
     * @return string
     */
    public function getOrderSnId()
    {
        return $this->orderSnId;
    }

    /**
     * -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功,
     * 
     * @return int
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * 完结时间
     * 
     * @return int
     */
    public function getOverTime()
    {
        return $this->overTime;
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
     * 支付类型编号
     * 
     * @return int
     */
    public function getPayType()
    {
        return $this->payType;
    }

    /**
     * 平台[：0代表pc，1代表app 2 wap, 3微商城]
     * 
     * @return int
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * 订单总价
     * 
     * @return float
     */
    public function getPriceSum()
    {
        return $this->priceSum;
    }

    /**
     * 订单备注
     * 
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * 运费【这样 就不用 重复计算两遍】
     * 
     * @return mixed
     */
    public function getShippingMonery()
    {
        return $this->shippingMonery;
    }

    /**
     * 0正常1删除
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺编号
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 是否需要发票【0不需要， 1要】
     * 
     * @return int
     */
    public function getTranslate()
    {
        return $this->translate;
    }

    /**
     * 用户编号
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
