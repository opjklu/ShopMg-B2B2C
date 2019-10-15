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
 * 店铺分类表
 *
 * @Entity()
 * @Table(name="mg_store_class")
 * 
 * @uses DbStoreClass
 */
class DbStoreClass extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id id编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $scBail 保证金数额
     *      @Column(name="sc_bail", type="integer")
     *      @Required()
     */
    private $scBail;

    /**
     *
     * @var string $scName 分类名称
     *      @Column(name="sc_name", type="string", length=50)
     *      @Required()
     */
    private $scName;

    /**
     *
     * @var int $scSort 排序
     *      @Column(name="sc_sort", type="tinyint")
     *      @Required()
     */
    private $scSort;

    /**
     *
     * @var int $status 是否启用【0关闭 1开启】
     *      @Column(name="status", type="tinyint")
     *      @Required()
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

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
     * id编号
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
     * 保证金数额
     * 
     * @param int $value            
     * @return $this
     */
    public function setScBail(int $value): self
    {
        $this->scBail = $value;
        
        return $this;
    }

    /**
     * 分类名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setScName(string $value): self
    {
        $this->scName = $value;
        
        return $this;
    }

    /**
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setScSort(int $value): self
    {
        $this->scSort = $value;
        
        return $this;
    }

    /**
     * 是否启用【0关闭 1开启】
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * id编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 保证金数额
     * 
     * @return int
     */
    public function getScBail()
    {
        return $this->scBail;
    }

    /**
     * 分类名称
     * 
     * @return string
     */
    public function getScName()
    {
        return $this->scName;
    }

    /**
     * 排序
     * 
     * @return int
     */
    public function getScSort()
    {
        return $this->scSort;
    }

    /**
     * 是否启用【0关闭 1开启】
     * 
     * @return int
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
