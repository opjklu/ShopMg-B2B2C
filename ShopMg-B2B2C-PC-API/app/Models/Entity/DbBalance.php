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
 * 用户余额表
 *
 * @Entity()
 * @Table(name="mg_balance")
 * 
 * @uses DbBalance
 */
class DbBalance extends Model
{

    /**
     *
     * @var float $accountBalance 账户余额
     *      @Column(name="account_balance", type="decimal")
     */
    private $accountBalance;

    /**
     *
     * @var float $changesBalance 变动余额
     *      @Column(name="changes_balance", type="float", default=0)
     */
    private $changesBalance;

    /**
     *
     * @var string $description 描述
     *      @Column(name="description", type="string", length=30)
     */
    private $description;

    /**
     *
     * @var int $id 主键id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var float $lockBalance 锁定余额
     *      @Column(name="lock_balance", type="decimal")
     */
    private $lockBalance;

    /**
     *
     * @var int $modifyTime 修改时间
     *      @Column(name="modify_time", type="integer")
     */
    private $modifyTime;

    /**
     *
     * @var int $rechargeTime 添加时间
     *      @Column(name="recharge_time", type="integer")
     */
    private $rechargeTime;

    /**
     *
     * @var int $status 1有效2过期
     *      @Column(name="status", type="tinyint")
     */
    private $status;

    /**
     *
     * @var int $type 类型 0消费 1为充值2提现类型 0消费 1为充值2提现3退货
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 账户余额
     * 
     * @param float $value            
     * @return $this
     */
    public function setAccountBalance(float $value): self
    {
        $this->accountBalance = $value;
        
        return $this;
    }

    /**
     * 变动余额
     * 
     * @param float $value            
     * @return $this
     */
    public function setChangesBalance(float $value): self
    {
        $this->changesBalance = $value;
        
        return $this;
    }

    /**
     * 描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setDescription(string $value): self
    {
        $this->description = $value;
        
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
     * 锁定余额
     * 
     * @param float $value            
     * @return $this
     */
    public function setLockBalance(float $value): self
    {
        $this->lockBalance = $value;
        
        return $this;
    }

    /**
     * 修改时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setModifyTime(int $value): self
    {
        $this->modifyTime = $value;
        
        return $this;
    }

    /**
     * 添加时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setRechargeTime(int $value): self
    {
        $this->rechargeTime = $value;
        
        return $this;
    }

    /**
     * 1有效2过期
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
     * 类型 0消费 1为充值2提现类型 0消费 1为充值2提现3退货
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
     * 账户余额
     * 
     * @return float
     */
    public function getAccountBalance()
    {
        return $this->accountBalance;
    }

    /**
     * 变动余额
     * 
     * @return mixed
     */
    public function getChangesBalance()
    {
        return $this->changesBalance;
    }

    /**
     * 描述
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * 锁定余额
     * 
     * @return float
     */
    public function getLockBalance()
    {
        return $this->lockBalance;
    }

    /**
     * 修改时间
     * 
     * @return int
     */
    public function getModifyTime()
    {
        return $this->modifyTime;
    }

    /**
     * 添加时间
     * 
     * @return int
     */
    public function getRechargeTime()
    {
        return $this->rechargeTime;
    }

    /**
     * 1有效2过期
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 类型 0消费 1为充值2提现类型 0消费 1为充值2提现3退货
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
