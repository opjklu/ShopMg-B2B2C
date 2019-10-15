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
 * 验证规则
 *
 * @Entity()
 * @Table(name="mg_auth_rule")
 * 
 * @uses DbAuthRule
 */
class DbAuthRule extends Model
{

    /**
     *
     * @var string $condition 条件
     *      @Column(name="condition", type="char", length=100, default="")
     */
    private $condition;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var string $entrance 入口文件
     *      @Column(name="entrance", type="string", length=80, default="adminprov.php")
     */
    private $entrance;

    /**
     *
     * @var string $fid 1在前 2在后
     *      @Column(name="fid", type="string", length=1, default="2")
     */
    private $fid;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="smallint")
     */
    private $id;

    /**
     *
     * @var string $name 名字
     *      @Column(name="name", type="string", length=80, default="")
     */
    private $name;

    /**
     *
     * @var int $pid 父级ID
     *      @Column(name="pid", type="smallint")
     */
    private $pid;

    /**
     *
     * @var string $remark 备注
     *      @Column(name="remark", type="text", length=65535)
     */
    private $remark;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="tinyint", default=50)
     */
    private $sort;

    /**
     *
     * @var int $status 状态
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var string $title 标题
     *      @Column(name="title", type="string", length=20, default="")
     */
    private $title;

    /**
     *
     * @var int $type 类型 【0 系统，1 商城，2 客户，】
     *      @Column(name="type", type="tinyint", default=1)
     */
    private $type;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer")
     */
    private $updateTime;

    /**
     *
     * @var string $xianshi 显示
     *      @Column(name="xianshi", type="string", length=1, default="0")
     */
    private $xianshi;

    /**
     * 条件
     * 
     * @param string $value            
     * @return $this
     */
    public function setCondition(string $value): self
    {
        $this->condition = $value;
        
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
     * 入口文件
     * 
     * @param string $value            
     * @return $this
     */
    public function setEntrance(string $value): self
    {
        $this->entrance = $value;
        
        return $this;
    }

    /**
     * 1在前 2在后
     * 
     * @param string $value            
     * @return $this
     */
    public function setFid(string $value): self
    {
        $this->fid = $value;
        
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
     * 名字
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
     * 父级ID
     * 
     * @param int $value            
     * @return $this
     */
    public function setPid(int $value): self
    {
        $this->pid = $value;
        
        return $this;
    }

    /**
     * 备注
     * 
     * @param string $value            
     * @return $this
     */
    public function setRemark(string $value): self
    {
        $this->remark = $value;
        
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
     * 状态
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
     * 标题
     * 
     * @param string $value            
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;
        
        return $this;
    }

    /**
     * 类型 【0 系统，1 商城，2 客户，】
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
     * 显示
     * 
     * @param string $value            
     * @return $this
     */
    public function setXianshi(string $value): self
    {
        $this->xianshi = $value;
        
        return $this;
    }

    /**
     * 条件
     * 
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
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
     * 入口文件
     * 
     * @return mixed
     */
    public function getEntrance()
    {
        return $this->entrance;
    }

    /**
     * 1在前 2在后
     * 
     * @return mixed
     */
    public function getFid()
    {
        return $this->fid;
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
     * 名字
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 父级ID
     * 
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * 备注
     * 
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * 排序
     * 
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 状态
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 标题
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 类型 【0 系统，1 商城，2 客户，】
     * 
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
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

    /**
     * 显示
     * 
     * @return string
     */
    public function getXianshi()
    {
        return $this->xianshi;
    }
}
