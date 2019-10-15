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
 * 运送方式表
 *
 * @Entity()
 * @Table(name="mg_freight_mode")
 * 
 * @uses DbFreightMode
 */
class DbFreightMode extends Model
{

    /**
     *
     * @var int $carryWay 运送方式编号【多商户废弃】
     *      @Column(name="carry_way", type="tinyint", default=0)
     */
    private $carryWay;

    /**
     *
     * @var float $continuedHeavy 续重
     *      @Column(name="continued_heavy", type="decimal", default=0)
     */
    private $continuedHeavy;

    /**
     *
     * @var float $continuedMoney 续费
     *      @Column(name="continued_money", type="decimal", default=0)
     */
    private $continuedMoney;

    /**
     *
     * @var int $continuedThing 续件
     *      @Column(name="continued_thing", type="integer", default=0)
     */
    private $continuedThing;

    /**
     *
     * @var float $continuedVolum 续体积
     *      @Column(name="continued_volum", type="decimal", default=0)
     */
    private $continuedVolum;

    /**
     *
     * @var int $firstThing 首件
     *      @Column(name="first_thing", type="integer")
     *      @Required()
     */
    private $firstThing;

    /**
     *
     * @var float $firstWeight 首重
     *      @Column(name="first_weight", type="decimal")
     *      @Required()
     */
    private $firstWeight;

    /**
     *
     * @var int $freightId 运费模板【编号】
     *      @Column(name="freight_id", type="integer", default=0)
     */
    private $freightId;

    /**
     *
     * @var float $fristMoney 首运费【起步价】
     *      @Column(name="frist_money", type="decimal", default=0)
     */
    private $fristMoney;

    /**
     *
     * @var float $fristVolum 首体积
     *      @Column(name="frist_volum", type="decimal")
     *      @Required()
     */
    private $fristVolum;

    /**
     *
     * @var int $id ID
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $storeId 店铺【id】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     * 运送方式编号【多商户废弃】
     * 
     * @param int $value            
     * @return $this
     */
    public function setCarryWay(int $value): self
    {
        $this->carryWay = $value;
        
        return $this;
    }

    /**
     * 续重
     * 
     * @param float $value            
     * @return $this
     */
    public function setContinuedHeavy(float $value): self
    {
        $this->continuedHeavy = $value;
        
        return $this;
    }

    /**
     * 续费
     * 
     * @param float $value            
     * @return $this
     */
    public function setContinuedMoney(float $value): self
    {
        $this->continuedMoney = $value;
        
        return $this;
    }

    /**
     * 续件
     * 
     * @param int $value            
     * @return $this
     */
    public function setContinuedThing(int $value): self
    {
        $this->continuedThing = $value;
        
        return $this;
    }

    /**
     * 续体积
     * 
     * @param float $value            
     * @return $this
     */
    public function setContinuedVolum(float $value): self
    {
        $this->continuedVolum = $value;
        
        return $this;
    }

    /**
     * 首件
     * 
     * @param int $value            
     * @return $this
     */
    public function setFirstThing(int $value): self
    {
        $this->firstThing = $value;
        
        return $this;
    }

    /**
     * 首重
     * 
     * @param float $value            
     * @return $this
     */
    public function setFirstWeight(float $value): self
    {
        $this->firstWeight = $value;
        
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
     * 首运费【起步价】
     * 
     * @param float $value            
     * @return $this
     */
    public function setFristMoney(float $value): self
    {
        $this->fristMoney = $value;
        
        return $this;
    }

    /**
     * 首体积
     * 
     * @param float $value            
     * @return $this
     */
    public function setFristVolum(float $value): self
    {
        $this->fristVolum = $value;
        
        return $this;
    }

    /**
     * ID
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
     * 运送方式编号【多商户废弃】
     * 
     * @return int
     */
    public function getCarryWay()
    {
        return $this->carryWay;
    }

    /**
     * 续重
     * 
     * @return mixed
     */
    public function getContinuedHeavy()
    {
        return $this->continuedHeavy;
    }

    /**
     * 续费
     * 
     * @return mixed
     */
    public function getContinuedMoney()
    {
        return $this->continuedMoney;
    }

    /**
     * 续件
     * 
     * @return int
     */
    public function getContinuedThing()
    {
        return $this->continuedThing;
    }

    /**
     * 续体积
     * 
     * @return mixed
     */
    public function getContinuedVolum()
    {
        return $this->continuedVolum;
    }

    /**
     * 首件
     * 
     * @return int
     */
    public function getFirstThing()
    {
        return $this->firstThing;
    }

    /**
     * 首重
     * 
     * @return float
     */
    public function getFirstWeight()
    {
        return $this->firstWeight;
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
     * 首运费【起步价】
     * 
     * @return mixed
     */
    public function getFristMoney()
    {
        return $this->fristMoney;
    }

    /**
     * 首体积
     * 
     * @return float
     */
    public function getFristVolum()
    {
        return $this->fristVolum;
    }

    /**
     * ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
}
