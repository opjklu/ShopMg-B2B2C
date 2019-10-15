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
 * 商品规格
 *
 * @Entity()
 * @Table(name="mg_goods_spec")
 * 
 * @uses DbGoodsSpec
 */
class DbGoodsSpec extends Model
{

    /**
     *
     * @var int $classOne 一级分类【id】
     *      @Column(name="class_one", type="integer", default=0)
     */
    private $classOne;

    /**
     *
     * @var int $classThree 三级分类
     *      @Column(name="class_three", type="integer", default=0)
     */
    private $classThree;

    /**
     *
     * @var int $classTwo 二级分类
     *      @Column(name="class_two", type="integer", default=0)
     */
    private $classTwo;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id 主键编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 规格名称
     *      @Column(name="name", type="string", length=50, default="")
     */
    private $name;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="integer", default=0)
     */
    private $sort;

    /**
     *
     * @var int $status 状态显示【1显示 0 不显示 默认显示】
     *      @Column(name="status", type="integer", default=1)
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     * 一级分类【id】
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
     * 主键编号
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
     * 规格名称
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
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setSort(int $value): self
    {
        $this->sort = $value;
        
        return $this;
    }

    /**
     * 状态显示【1显示 0 不显示 默认显示】
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
     * 一级分类【id】
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
     * 主键编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 规格名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 排序
     * 
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 状态显示【1显示 0 不显示 默认显示】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
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
