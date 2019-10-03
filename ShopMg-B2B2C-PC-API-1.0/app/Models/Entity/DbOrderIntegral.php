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
 * 积分订单
 *
 * @Entity()
 * @Table(name="mg_order_integral")
 * 
 * @uses DbOrderIntegral
 */
class DbOrderIntegral extends Model
{

    /**
     *
     * @var int $addressId 收货地址【编号】
     *      @Column(name="address_id", type="integer")
     */
    private $addressId;

    /**
     *
     * @var int $commentStatus 评价状态 0未评价 1已评价
     *      @Column(name="comment_status", type="tinyint", default=0)
     */
    private $commentStatus;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer", default=0)
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
     *      @Column(name="express_id", type="bigint", default=0)
     */
    private $expressId;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $interaglTotal 使用积分总数
     *      @Column(name="interagl_total", type="integer", default=0)
     */
    private $interaglTotal;

    /**
     *
     * @var string $orderSn 订单标志
     *      @Column(name="order_sn", type="string", length=50)
     *      @Required()
     */
    private $orderSn;

    /**
     *
     * @var int $orderStatus -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功,
     *      @Column(name="order_status", type="tinyint", default=0)
     */
    private $orderStatus;

    /**
     *
     * @var int $orderType 订单类型【0普通订单1货到付款】
     *      @Column(name="order_type", type="tinyint", default=0)
     */
    private $orderType;

    /**
     *
     * @var int $overTime 完结时间
     *      @Column(name="over_time", type="integer")
     */
    private $overTime;

    /**
     *
     * @var int $payTime 支付时间
     *      @Column(name="pay_time", type="integer", default=0)
     */
    private $payTime;

    /**
     *
     * @var int $payType 支付类型编号
     *      @Column(name="pay_type", type="integer", default=0)
     */
    private $payType;

    /**
     *
     * @var int $platform 平台【0代表pc，1代表app，2Wap, 3微商城】
     *      @Column(name="platform", type="tinyint", default=0)
     */
    private $platform;

    /**
     *
     * @var float $priceSum 花费金额
     *      @Column(name="price_sum", type="decimal", default=0)
     */
    private $priceSum;

    /**
     *
     * @var string $remarks 订单备注
     *      @Column(name="remarks", type="string", length=52, default="")
     */
    private $remarks;

    /**
     *
     * @var float $shippingMonery 运费【这样 就不用 重复计算两遍】
     *      @Column(name="shipping_monery", type="float", default=0)
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
     * @var int $storeId 店铺
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $translate 1需要发票，0不需要
     *      @Column(name="translate", type="tinyint", default=0)
     */
    private $translate;

    /**
     *
     * @var int $userId 用户
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     *
     * @var int $wareId 仓库编号
     *      @Column(name="ware_id", type="integer", default=0)
     */
    private $wareId;

    /**
     * 收货地址【编号】
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
     * 使用积分总数
     * 
     * @param int $value            
     * @return $this
     */
    public function setInteraglTotal(int $value): self
    {
        $this->interaglTotal = $value;
        
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
     * 订单类型【0普通订单1货到付款】
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderType(int $value): self
    {
        $this->orderType = $value;
        
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
     * 平台【0代表pc，1代表app，2Wap, 3微商城】
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
     * 花费金额
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
     * 1需要发票，0不需要
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
     * 仓库编号
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
     * 收货地址【编号】
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
     * 编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 使用积分总数
     * 
     * @return int
     */
    public function getInteraglTotal()
    {
        return $this->interaglTotal;
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
     * -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功,
     * 
     * @return int
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * 订单类型【0普通订单1货到付款】
     * 
     * @return int
     */
    public function getOrderType()
    {
        return $this->orderType;
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
     * 平台【0代表pc，1代表app，2Wap, 3微商城】
     * 
     * @return int
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * 花费金额
     * 
     * @return mixed
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
     * 店铺
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 1需要发票，0不需要
     * 
     * @return int
     */
    public function getTranslate()
    {
        return $this->translate;
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

    /**
     * 仓库编号
     * 
     * @return int
     */
    public function getWareId()
    {
        return $this->wareId;
    }
}
