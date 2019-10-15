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
 * 代金券详情表
 *
 * @Entity()
 * @Table(name="mg_coupon_list")
 * 
 * @uses DbCouponList
 */
class DbCouponList extends Model
{

    /**
     *
     * @var int $cId 优惠券 对应coupon表id
     *      @Column(name="c_id", type="integer", default=0)
     */
    private $cId;

    /**
     *
     * @var string $code 优惠券兑换码
     *      @Column(name="code", type="string", length=16)
     */
    private $code;

    /**
     *
     * @var int $id 表id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderId 订单id
     *      @Column(name="order_id", type="integer", default=0)
     */
    private $orderId;

    /**
     *
     * @var int $sendTime 发放时间
     *      @Column(name="send_time", type="integer", default=0)
     */
    private $sendTime;

    /**
     *
     * @var int $status 0未使用1已使用
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $type 发放类型 【0免费发放1 按用户发放 2 注册 3 邀请,4 线下发放，5 下单发放 】
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var int $useTime 使用时间
     *      @Column(name="use_time", type="integer", default=0)
     */
    private $useTime;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     * 优惠券 对应coupon表id
     * 
     * @param int $value            
     * @return $this
     */
    public function setCId(int $value): self
    {
        $this->cId = $value;
        
        return $this;
    }

    /**
     * 优惠券兑换码
     * 
     * @param string $value            
     * @return $this
     */
    public function setCode(string $value): self
    {
        $this->code = $value;
        
        return $this;
    }

    /**
     * 表id
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
     * 发放时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setSendTime(int $value): self
    {
        $this->sendTime = $value;
        
        return $this;
    }

    /**
     * 0未使用1已使用
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
     * 发放类型 【0免费发放1 按用户发放 2 注册 3 邀请,4 线下发放，5 下单发放 】
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
     * 使用时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setUseTime(int $value): self
    {
        $this->useTime = $value;
        
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
     * 优惠券 对应coupon表id
     * 
     * @return int
     */
    public function getCId()
    {
        return $this->cId;
    }

    /**
     * 优惠券兑换码
     * 
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 表id
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
     * 发放时间
     * 
     * @return int
     */
    public function getSendTime()
    {
        return $this->sendTime;
    }

    /**
     * 0未使用1已使用
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 发放类型 【0免费发放1 按用户发放 2 注册 3 邀请,4 线下发放，5 下单发放 】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 使用时间
     * 
     * @return int
     */
    public function getUseTime()
    {
        return $this->useTime;
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
