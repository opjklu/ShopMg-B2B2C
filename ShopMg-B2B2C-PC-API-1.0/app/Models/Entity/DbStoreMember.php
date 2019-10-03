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
 * 店铺会员表
 *
 * @Entity()
 * @Table(name="mg_store_member")
 * 
 * @uses DbStoreMember
 */
class DbStoreMember extends Model
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
     * @var int $lastTime 上次交易时间
     *      @Column(name="last_time", type="bigint", default=0)
     */
    private $lastTime;

    /**
     *
     * @var int $memberId 用户【编号】
     *      @Column(name="member_id", type="bigint", default=0)
     */
    private $memberId;

    /**
     *
     * @var float $moneyBig 金额上限
     *      @Column(name="money_big", type="decimal", default=0)
     */
    private $moneyBig;

    /**
     *
     * @var float $moneySmall 金额下限
     *      @Column(name="money_small", type="decimal", default=0)
     */
    private $moneySmall;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var float $totalTransaction 交易总额
     *      @Column(name="total_transaction", type="decimal", default=0)
     */
    private $totalTransaction;

    /**
     *
     * @var int $transactionNumber 交易笔数
     *      @Column(name="transaction_number", type="integer", default=0)
     */
    private $transactionNumber;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

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
     * 上次交易时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setLastTime(int $value): self
    {
        $this->lastTime = $value;
        
        return $this;
    }

    /**
     * 用户【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setMemberId(int $value): self
    {
        $this->memberId = $value;
        
        return $this;
    }

    /**
     * 金额上限
     * 
     * @param float $value            
     * @return $this
     */
    public function setMoneyBig(float $value): self
    {
        $this->moneyBig = $value;
        
        return $this;
    }

    /**
     * 金额下限
     * 
     * @param float $value            
     * @return $this
     */
    public function setMoneySmall(float $value): self
    {
        $this->moneySmall = $value;
        
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
     * 交易总额
     * 
     * @param float $value            
     * @return $this
     */
    public function setTotalTransaction(float $value): self
    {
        $this->totalTransaction = $value;
        
        return $this;
    }

    /**
     * 交易笔数
     * 
     * @param int $value            
     * @return $this
     */
    public function setTransactionNumber(int $value): self
    {
        $this->transactionNumber = $value;
        
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
     * 编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 上次交易时间
     * 
     * @return int
     */
    public function getLastTime()
    {
        return $this->lastTime;
    }

    /**
     * 用户【编号】
     * 
     * @return int
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * 金额上限
     * 
     * @return mixed
     */
    public function getMoneyBig()
    {
        return $this->moneyBig;
    }

    /**
     * 金额下限
     * 
     * @return mixed
     */
    public function getMoneySmall()
    {
        return $this->moneySmall;
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
     * 交易总额
     * 
     * @return mixed
     */
    public function getTotalTransaction()
    {
        return $this->totalTransaction;
    }

    /**
     * 交易笔数
     * 
     * @return int
     */
    public function getTransactionNumber()
    {
        return $this->transactionNumber;
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
