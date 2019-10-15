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
 * 提现记录表
 *
 * @Entity()
 * @Table(name="mg_reflect")
 * 
 * @uses DbReflect
 */
class DbReflect extends Model
{

    /**
     *
     * @var string $account 收款账号
     *      @Column(name="account", type="string", length=255, default="0")
     */
    private $account;

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
     * @var int $status -1:未通过,0:待审批,1:待打款,2:已打款
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $typeId 体现类型【关联pay_type】
     *      @Column(name="type_id", type="tinyint", default=0)
     */
    private $typeId;

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
     * 收款账号
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
     * -1:未通过,0:待审批,1:待打款,2:已打款
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
     * 体现类型【关联pay_type】
     * 
     * @param int $value            
     * @return $this
     */
    public function setTypeId(int $value): self
    {
        $this->typeId = $value;
        
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
     * 收款账号
     * 
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
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
     * -1:未通过,0:待审批,1:待打款,2:已打款
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 体现类型【关联pay_type】
     * 
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
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
