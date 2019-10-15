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
 * 代金券表
 *
 * @Entity()
 * @Table(name="mg_coupon")
 * 
 * @uses DbCoupon
 */
class DbCoupon extends Model
{

    /**
     *
     * @var int $addTime 添加时间
     *      @Column(name="add_time", type="bigint")
     */
    private $addTime;

    /**
     *
     * @var float $condition 使用条件
     *      @Column(name="condition", type="decimal", default=0)
     */
    private $condition;

    /**
     *
     * @var int $createnum 发放数量
     *      @Column(name="createnum", type="integer", default=0)
     */
    private $createnum;

    /**
     *
     * @var int $id 表id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var float $money 优惠券金额
     *      @Column(name="money", type="decimal", default=0)
     */
    private $money;

    /**
     *
     * @var string $name 优惠券名字
     *      @Column(name="name", type="string", length=50)
     *      @Required()
     */
    private $name;

    /**
     *
     * @var int $sendAll 发放状态【0 平台全部会员都可发放 1只发店铺会员】
     *      @Column(name="send_all", type="tinyint", default=0)
     */
    private $sendAll;

    /**
     *
     * @var int $sendEndTime 发放结束时间
     *      @Column(name="send_end_time", type="integer")
     */
    private $sendEndTime;

    /**
     *
     * @var int $sendNum 已领取数量
     *      @Column(name="send_num", type="integer", default=0)
     */
    private $sendNum;

    /**
     *
     * @var int $sendStartTime 发放开始时间
     *      @Column(name="send_start_time", type="integer")
     */
    private $sendStartTime;

    /**
     *
     * @var int $status 是否有效
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺【id】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $type 发放类型 【0免费领取1 按用户发放 2 注册 3 邀请,4 线下发放，5 下单发放 】
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     */
    private $updateTime;

    /**
     *
     * @var int $useEndTime 使用结束时间
     *      @Column(name="use_end_time", type="integer")
     */
    private $useEndTime;

    /**
     *
     * @var int $useNum 已使用数量
     *      @Column(name="use_num", type="integer", default=0)
     */
    private $useNum;

    /**
     *
     * @var int $useStartTime 使用开始时间
     *      @Column(name="use_start_time", type="integer")
     */
    private $useStartTime;

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
     * 使用条件
     * 
     * @param float $value            
     * @return $this
     */
    public function setCondition(float $value): self
    {
        $this->condition = $value;
        
        return $this;
    }

    /**
     * 发放数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setCreatenum(int $value): self
    {
        $this->createnum = $value;
        
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
     * 优惠券金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setMoney(float $value): self
    {
        $this->money = $value;
        
        return $this;
    }

    /**
     * 优惠券名字
     * 
     * @param string $value            
     * @return $this
     */
    public function setName(string $value): self
    {
        $this->name = $value;
        
        return $this;
    }

    /**
     * 发放状态【0 平台全部会员都可发放 1只发店铺会员】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSendAll(int $value): self
    {
        $this->sendAll = $value;
        
        return $this;
    }

    /**
     * 发放结束时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setSendEndTime(int $value): self
    {
        $this->sendEndTime = $value;
        
        return $this;
    }

    /**
     * 已领取数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setSendNum(int $value): self
    {
        $this->sendNum = $value;
        
        return $this;
    }

    /**
     * 发放开始时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setSendStartTime(int $value): self
    {
        $this->sendStartTime = $value;
        
        return $this;
    }

    /**
     * 是否有效
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
     * 店铺【id】
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
     * 发放类型 【0免费领取1 按用户发放 2 注册 3 邀请,4 线下发放，5 下单发放 】
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
     * 使用结束时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setUseEndTime(int $value): self
    {
        $this->useEndTime = $value;
        
        return $this;
    }

    /**
     * 已使用数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setUseNum(int $value): self
    {
        $this->useNum = $value;
        
        return $this;
    }

    /**
     * 使用开始时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setUseStartTime(int $value): self
    {
        $this->useStartTime = $value;
        
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
     * 使用条件
     * 
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * 发放数量
     * 
     * @return int
     */
    public function getCreatenum()
    {
        return $this->createnum;
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
     * 优惠券金额
     * 
     * @return mixed
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * 优惠券名字
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 发放状态【0 平台全部会员都可发放 1只发店铺会员】
     * 
     * @return int
     */
    public function getSendAll()
    {
        return $this->sendAll;
    }

    /**
     * 发放结束时间
     * 
     * @return int
     */
    public function getSendEndTime()
    {
        return $this->sendEndTime;
    }

    /**
     * 已领取数量
     * 
     * @return int
     */
    public function getSendNum()
    {
        return $this->sendNum;
    }

    /**
     * 发放开始时间
     * 
     * @return int
     */
    public function getSendStartTime()
    {
        return $this->sendStartTime;
    }

    /**
     * 是否有效
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺【id】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 发放类型 【0免费领取1 按用户发放 2 注册 3 邀请,4 线下发放，5 下单发放 】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
     * 使用结束时间
     * 
     * @return int
     */
    public function getUseEndTime()
    {
        return $this->useEndTime;
    }

    /**
     * 已使用数量
     * 
     * @return int
     */
    public function getUseNum()
    {
        return $this->useNum;
    }

    /**
     * 使用开始时间
     * 
     * @return int
     */
    public function getUseStartTime()
    {
        return $this->useStartTime;
    }
}
