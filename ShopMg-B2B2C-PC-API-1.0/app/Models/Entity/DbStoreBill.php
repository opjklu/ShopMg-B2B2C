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
 * 商家结算表
 *
 * @Entity()
 * @Table(name="mg_store_bill")
 * 
 * @uses DbStoreBill
 */
class DbStoreBill extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $endTime 结束时间
     *      @Column(name="end_time", type="bigint", default=0)
     */
    private $endTime;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var float $orderPrice 订单总价
     *      @Column(name="order_price", type="decimal", default=0)
     */
    private $orderPrice;

    /**
     *
     * @var string $payRemarks 备注
     *      @Column(name="pay_remarks", type="char", length=100, default="")
     */
    private $payRemarks;

    /**
     *
     * @var int $payTime 付款时间
     *      @Column(name="pay_time", type="bigint", default=0)
     */
    private $payTime;

    /**
     *
     * @var float $platformPercentage 平台抽成
     *      @Column(name="platform_percentage", type="decimal", default=0)
     */
    private $platformPercentage;

    /**
     *
     * @var int $startTime 开始时间
     *      @Column(name="start_time", type="bigint", default=0)
     */
    private $startTime;

    /**
     *
     * @var int $status 账单状态【0默认1店家已确认2店家拒绝，3平台已审核4平台拒绝5结算完成】
     *      @Column(name="status", type="tinyint")
     *      @Required()
     */
    private $status;

    /**
     *
     * @var string $stmentSn 唯一标示码
     *      @Column(name="stment_sn", type="char", length=50)
     */
    private $stmentSn;

    /**
     *
     * @var int $storeId 商户【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var float $totalShipping 总运费
     *      @Column(name="total_shipping", type="decimal", default=0)
     */
    private $totalShipping;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

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
     * 结束时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setEndTime(int $value): self
    {
        $this->endTime = $value;
        
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
     * 订单总价
     * 
     * @param float $value            
     * @return $this
     */
    public function setOrderPrice(float $value): self
    {
        $this->orderPrice = $value;
        
        return $this;
    }

    /**
     * 备注
     * 
     * @param string $value            
     * @return $this
     */
    public function setPayRemarks(string $value): self
    {
        $this->payRemarks = $value;
        
        return $this;
    }

    /**
     * 付款时间
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
     * 平台抽成
     * 
     * @param float $value            
     * @return $this
     */
    public function setPlatformPercentage(float $value): self
    {
        $this->platformPercentage = $value;
        
        return $this;
    }

    /**
     * 开始时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setStartTime(int $value): self
    {
        $this->startTime = $value;
        
        return $this;
    }

    /**
     * 账单状态【0默认1店家已确认2店家拒绝，3平台已审核4平台拒绝5结算完成】
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
     * 唯一标示码
     * 
     * @param string $value            
     * @return $this
     */
    public function setStmentSn(string $value): self
    {
        $this->stmentSn = $value;
        
        return $this;
    }

    /**
     * 商户【编号】
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
     * 总运费
     * 
     * @param float $value            
     * @return $this
     */
    public function setTotalShipping(float $value): self
    {
        $this->totalShipping = $value;
        
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 结束时间
     * 
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
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
     * 订单总价
     * 
     * @return mixed
     */
    public function getOrderPrice()
    {
        return $this->orderPrice;
    }

    /**
     * 备注
     * 
     * @return string
     */
    public function getPayRemarks()
    {
        return $this->payRemarks;
    }

    /**
     * 付款时间
     * 
     * @return int
     */
    public function getPayTime()
    {
        return $this->payTime;
    }

    /**
     * 平台抽成
     * 
     * @return mixed
     */
    public function getPlatformPercentage()
    {
        return $this->platformPercentage;
    }

    /**
     * 开始时间
     * 
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * 账单状态【0默认1店家已确认2店家拒绝，3平台已审核4平台拒绝5结算完成】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 唯一标示码
     * 
     * @return string
     */
    public function getStmentSn()
    {
        return $this->stmentSn;
    }

    /**
     * 商户【编号】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 总运费
     * 
     * @return mixed
     */
    public function getTotalShipping()
    {
        return $this->totalShipping;
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
}
