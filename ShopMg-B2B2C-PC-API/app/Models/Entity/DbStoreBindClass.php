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
 * 店铺可发布商品类目表
 *
 * @Entity()
 * @Table(name="mg_store_bind_class")
 * 
 * @uses DbStoreBindClass
 */
class DbStoreBindClass extends Model
{

    /**
     *
     * @var int $classOne 一级分类
     *      @Column(name="class_one", type="integer")
     *      @Required()
     */
    private $classOne;

    /**
     *
     * @var int $classThree 三及分类
     *      @Column(name="class_three", type="integer", default=0)
     */
    private $classThree;

    /**
     *
     * @var int $classTwo 二级分类
     *      @Column(name="class_two", type="integer")
     *      @Required()
     */
    private $classTwo;

    /**
     *
     * @var int $commisRate 佣金比例
     *      @Column(name="commis_rate", type="integer", default=0)
     */
    private $commisRate;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $status 状态【0审核中1已审核 2平台自营店铺】
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺名称【id】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     * 一级分类
     * 
     * @param int $value            
     * @return $this
     */
    public function setClassOne(int $value): self
    {
        $this->classOne = $value;
        
        return $this;
    }

    /**
     * 三及分类
     * 
     * @param int $value            
     * @return $this
     */
    public function setClassThree(int $value): self
    {
        $this->classThree = $value;
        
        return $this;
    }

    /**
     * 二级分类
     * 
     * @param int $value            
     * @return $this
     */
    public function setClassTwo(int $value): self
    {
        $this->classTwo = $value;
        
        return $this;
    }

    /**
     * 佣金比例
     * 
     * @param int $value            
     * @return $this
     */
    public function setCommisRate(int $value): self
    {
        $this->commisRate = $value;
        
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
     * 状态【0审核中1已审核 2平台自营店铺】
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
     * 店铺名称【id】
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
     * 一级分类
     * 
     * @return int
     */
    public function getClassOne()
    {
        return $this->classOne;
    }

    /**
     * 三及分类
     * 
     * @return int
     */
    public function getClassThree()
    {
        return $this->classThree;
    }

    /**
     * 二级分类
     * 
     * @return int
     */
    public function getClassTwo()
    {
        return $this->classTwo;
    }

    /**
     * 佣金比例
     * 
     * @return int
     */
    public function getCommisRate()
    {
        return $this->commisRate;
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
     * 状态【0审核中1已审核 2平台自营店铺】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺名称【id】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
