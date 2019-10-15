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
 * 积分表
 *
 * @Entity()
 * @Table(name="mg_integral_use")
 * 
 * @uses DbIntegralUse
 */
class DbIntegralUse extends Model
{

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
     *      @Column(name="integral", type="integer", default=0)
     */
    private $integral;

    /**
     *
     * @var int $orderId 订单【id】
     *      @Column(name="order_id", type="integer", default=0)
     */
    private $orderId;

    /**
     *
     * @var string $remarks 备注
     *      @Column(name="remarks", type="string", length=200)
     */
    private $remarks;

    /**
     *
     * @var int $status 是否有效【1.可用;2.已用;0.过期;】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $tradingTime 交易时间
     *      @Column(name="trading_time", type="bigint", default=0)
     */
    private $tradingTime;

    /**
     *
     * @var int $type 积分类型【1收入0 支出】
     *      @Column(name="type", type="tinyint")
     *      @Required()
     */
    private $type;

    /**
     *
     * @var int $userId 用户【id】
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

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
     * 订单【id】
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
     * 备注
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
     * 是否有效【1.可用;2.已用;0.过期;】
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
     * 交易时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setTradingTime(int $value): self
    {
        $this->tradingTime = $value;
        
        return $this;
    }

    /**
     * 积分类型【1收入0 支出】
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
     * 订单【id】
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 备注
     * 
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * 是否有效【1.可用;2.已用;0.过期;】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 交易时间
     * 
     * @return int
     */
    public function getTradingTime()
    {
        return $this->tradingTime;
    }

    /**
     * 积分类型【1收入0 支出】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
