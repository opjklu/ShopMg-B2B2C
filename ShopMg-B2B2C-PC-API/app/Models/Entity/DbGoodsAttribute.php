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
 * 商品属性表
 *
 * @Entity()
 * @Table(name="mg_goods_attribute")
 * 
 * @uses DbGoodsAttribute
 */
class DbGoodsAttribute extends Model
{

    /**
     *
     * @var int $attrIndex 0不需要检索 1关键字检索
     *      @Column(name="attr_index", type="tinyint", default=0)
     */
    private $attrIndex;

    /**
     *
     * @var string $attrName 属性名称
     *      @Column(name="attr_name", type="string", length=60, default="")
     */
    private $attrName;

    /**
     *
     * @var int $attrType 0唯一属性 1单选属性 2复选属性
     *      @Column(name="attr_type", type="tinyint", default=0)
     */
    private $attrType;

    /**
     *
     * @var string $attrValues 可选值列表
     *      @Column(name="attr_values", type="text", length=65535)
     *      @Required()
     */
    private $attrValues;

    /**
     *
     * @var int $classOne 一级分类
     *      @Column(name="class_one", type="integer", default=0)
     */
    private $classOne;

    /**
     *
     * @var int $classThree 三级分类
     *      @Column(name="class_three", type="integer")
     *      @Required()
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
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id 属性id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $inputType 0 手工录入 1从列表中选择 2多行文本框
     *      @Column(name="input_type", type="tinyint", default=0)
     */
    private $inputType;

    /**
     *
     * @var int $orderSort 属性排序
     *      @Column(name="order_sort", type="tinyint", default=50)
     */
    private $orderSort;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer", default=0)
     */
    private $updateTime;

    /**
     * 0不需要检索 1关键字检索
     * 
     * @param int $value            
     * @return $this
     */
    public function setAttrIndex(int $value): self
    {
        $this->attrIndex = $value;
        
        return $this;
    }

    /**
     * 属性名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setAttrName(string $value): self
    {
        $this->attrName = $value;
        
        return $this;
    }

    /**
     * 0唯一属性 1单选属性 2复选属性
     * 
     * @param int $value            
     * @return $this
     */
    public function setAttrType(int $value): self
    {
        $this->attrType = $value;
        
        return $this;
    }

    /**
     * 可选值列表
     * 
     * @param string $value            
     * @return $this
     */
    public function setAttrValues(string $value): self
    {
        $this->attrValues = $value;
        
        return $this;
    }

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
     * 三级分类
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
     * 属性id
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
     * 0 手工录入 1从列表中选择 2多行文本框
     * 
     * @param int $value            
     * @return $this
     */
    public function setInputType(int $value): self
    {
        $this->inputType = $value;
        
        return $this;
    }

    /**
     * 属性排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderSort(int $value): self
    {
        $this->orderSort = $value;
        
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
     * 0不需要检索 1关键字检索
     * 
     * @return int
     */
    public function getAttrIndex()
    {
        return $this->attrIndex;
    }

    /**
     * 属性名称
     * 
     * @return string
     */
    public function getAttrName()
    {
        return $this->attrName;
    }

    /**
     * 0唯一属性 1单选属性 2复选属性
     * 
     * @return int
     */
    public function getAttrType()
    {
        return $this->attrType;
    }

    /**
     * 可选值列表
     * 
     * @return string
     */
    public function getAttrValues()
    {
        return $this->attrValues;
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
     * 三级分类
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 属性id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 0 手工录入 1从列表中选择 2多行文本框
     * 
     * @return int
     */
    public function getInputType()
    {
        return $this->inputType;
    }

    /**
     * 属性排序
     * 
     * @return mixed
     */
    public function getOrderSort()
    {
        return $this->orderSort;
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
