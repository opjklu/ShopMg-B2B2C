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
 * 提现表
 *
 * @Entity()
 * @Table(name="mg_withdrawal")
 * 
 * @uses DbWithdrawal
 */
class DbWithdrawal extends Model
{

    /**
     *
     * @var string $account 提现账号
     *      @Column(name="account", type="string", length=255, default="0")
     */
    private $account;

    /**
     *
     * @var int $cashType 提现平台【例如支付宝】
     *      @Column(name="cash_type", type="tinyint", default=0)
     */
    private $cashType;

    /**
     *
     * @var int $createTime 添加时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var float $money 提现金额
     *      @Column(name="money", type="decimal", default=0)
     */
    private $money;

    /**
     *
     * @var int $platformType 平台类型【0 PC， 1 mobile 2微商城】
     *      @Column(name="platform_type", type="tinyint", default=0)
     */
    private $platformType;

    /**
     *
     * @var int $status 状态【0 异常，1 正常】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $updateTime 最后修改时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     * 提现账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setAccount(string $value): self
    {
        $this->account = $value;
        
        return $this;
    }

    /**
     * 提现平台【例如支付宝】
     * 
     * @param int $value            
     * @return $this
     */
    public function setCashType(int $value): self
    {
        $this->cashType = $value;
        
        return $this;
    }

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
     * 提现金额
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
     * 平台类型【0 PC， 1 mobile 2微商城】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPlatformType(int $value): self
    {
        $this->platformType = $value;
        
        return $this;
    }

    /**
     * 状态【0 异常，1 正常】
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
     * 最后修改时间
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
     * 提现账号
     * 
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * 提现平台【例如支付宝】
     * 
     * @return int
     */
    public function getCashType()
    {
        return $this->cashType;
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
     * id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 提现金额
     * 
     * @return mixed
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * 平台类型【0 PC， 1 mobile 2微商城】
     * 
     * @return int
     */
    public function getPlatformType()
    {
        return $this->platformType;
    }

    /**
     * 状态【0 异常，1 正常】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 最后修改时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
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
