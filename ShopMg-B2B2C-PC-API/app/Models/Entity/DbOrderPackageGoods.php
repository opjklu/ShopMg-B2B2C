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
 * 套餐商品订单商品表
 *
 * @Entity()
 * @Table(name="mg_order_package_goods")
 * 
 * @uses DbOrderPackageGoods
 */
class DbOrderPackageGoods extends Model
{

    /**
     *
     * @var int $createTime 添加时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $freightId 运费模板【编号】
     *      @Column(name="freight_id", type="integer", default=0)
     */
    private $freightId;

    /**
     *
     * @var float $goodsDiscount 单个商品套餐价
     *      @Column(name="goods_discount", type="decimal")
     *      @Required()
     */
    private $goodsDiscount;

    /**
     *
     * @var int $goodsId 商品id
     *      @Column(name="goods_id", type="integer")
     *      @Required()
     */
    private $goodsId;

    /**
     *
     * @var int $id 主键id
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
     *
     * @var float $packageDiscount 单个套餐优惠总价
     *      @Column(name="package_discount", type="decimal")
     *      @Required()
     */
    private $packageDiscount;

    /**
     *
     * @var int $packageId 套餐id
     *      @Column(name="package_id", type="integer")
     *      @Required()
     */
    private $packageId;

    /**
     *
     * @var int $packageNum 套餐数量
     *      @Column(name="package_num", type="integer")
     *      @Required()
     */
    private $packageNum;

    /**
     *
     * @var float $packageTotal 单个套餐商品总价
     *      @Column(name="package_total", type="decimal")
     *      @Required()
     */
    private $packageTotal;

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
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户【id】
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 添加时间
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
     * 运费模板【编号】
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
     * 单个商品套餐价
     * 
     * @param float $value            
     * @return $this
     */
    public function setGoodsDiscount(float $value): self
    {
        $this->goodsDiscount = $value;
        
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
     * 主键id
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
     * 单个套餐优惠总价
     * 
     * @param float $value            
     * @return $this
     */
    public function setPackageDiscount(float $value): self
    {
        $this->packageDiscount = $value;
        
        return $this;
    }

    /**
     * 套餐id
     * 
     * @param int $value            
     * @return $this
     */
    public function setPackageId(int $value): self
    {
        $this->packageId = $value;
        
        return $this;
    }

    /**
     * 套餐数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setPackageNum(int $value): self
    {
        $this->packageNum = $value;
        
        return $this;
    }

    /**
     * 单个套餐商品总价
     * 
     * @param float $value            
     * @return $this
     */
    public function setPackageTotal(float $value): self
    {
        $this->packageTotal = $value;
        
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
     * 更新时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setUpdateTime(int $value): self
    {
        $this->updateTime = $value;
        
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
     * 添加时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 运费模板【编号】
     * 
     * @return int
     */
    public function getFreightId()
    {
        return $this->freightId;
    }

    /**
     * 单个商品套餐价
     * 
     * @return float
     */
    public function getGoodsDiscount()
    {
        return $this->goodsDiscount;
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
     * 主键id
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

    /**
     * 单个套餐优惠总价
     * 
     * @return float
     */
    public function getPackageDiscount()
    {
        return $this->packageDiscount;
    }

    /**
     * 套餐id
     * 
     * @return int
     */
    public function getPackageId()
    {
        return $this->packageId;
    }

    /**
     * 套餐数量
     * 
     * @return int
     */
    public function getPackageNum()
    {
        return $this->packageNum;
    }

    /**
     * 单个套餐商品总价
     * 
     * @return float
     */
    public function getPackageTotal()
    {
        return $this->packageTotal;
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
     * 更新时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
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
