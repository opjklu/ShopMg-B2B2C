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
 * 店铺会员等级表
 *
 * @Entity()
 * @Table(name="mg_store_member_level")
 * 
 * @uses DbStoreMemberLevel
 */
class DbStoreMemberLevel extends Model
{

    /**
     *
     * @var float $conditionMoney 金额条件【弃用】
     *      @Column(name="condition_money", type="decimal", default=0)
     */
    private $conditionMoney;

    /**
     *
     * @var int $conditionNum 交易笔数下限
     *      @Column(name="condition_num", type="integer", default=0)
     */
    private $conditionNum;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var float $discount 折扣
     *      @Column(name="discount", type="decimal", default=0)
     */
    private $discount;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $levelId 【平台设置的】店铺会员等级【编号】
     *      @Column(name="level_id", type="integer", default=0)
     */
    private $levelId;

    /**
     *
     * @var float $moneyBig 金额上限
     *      @Column(name="money_big", type="float", default=0)
     */
    private $moneyBig;

    /**
     *
     * @var float $moneySmall 金额下限
     *      @Column(name="money_small", type="float", default=0)
     */
    private $moneySmall;

    /**
     *
     * @var int $numBig 交易笔数上限
     *      @Column(name="num_big", type="integer", default=0)
     */
    private $numBig;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     * 金额条件【弃用】
     * 
     * @param float $value            
     * @return $this
     */
    public function setConditionMoney(float $value): self
    {
        $this->conditionMoney = $value;
        
        return $this;
    }

    /**
     * 交易笔数下限
     * 
     * @param int $value            
     * @return $this
     */
    public function setConditionNum(int $value): self
    {
        $this->conditionNum = $value;
        
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
     * 折扣
     * 
     * @param float $value            
     * @return $this
     */
    public function setDiscount(float $value): self
    {
        $this->discount = $value;
        
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
     * 【平台设置的】店铺会员等级【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setLevelId(int $value): self
    {
        $this->levelId = $value;
        
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
     * 交易笔数上限
     * 
     * @param int $value            
     * @return $this
     */
    public function setNumBig(int $value): self
    {
        $this->numBig = $value;
        
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
     * 金额条件【弃用】
     * 
     * @return mixed
     */
    public function getConditionMoney()
    {
        return $this->conditionMoney;
    }

    /**
     * 交易笔数下限
     * 
     * @return int
     */
    public function getConditionNum()
    {
        return $this->conditionNum;
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
     * 折扣
     * 
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
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
     * 【平台设置的】店铺会员等级【编号】
     * 
     * @return int
     */
    public function getLevelId()
    {
        return $this->levelId;
    }

    /**
     * 金额上限
     * 
     * @return float
     */
    public function getMoneyBig()
    {
        return $this->moneyBig;
    }

    /**
     * 金额下限
     * 
     * @return float
     */
    public function getMoneySmall()
    {
        return $this->moneySmall;
    }

    /**
     * 交易笔数上限
     * 
     * @return int
     */
    public function getNumBig()
    {
        return $this->numBig;
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
}
