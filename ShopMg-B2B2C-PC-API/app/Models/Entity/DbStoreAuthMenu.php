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
 * 商户管理中心权限菜单
 *
 * @Entity()
 * @Table(name="mg_store_auth_menu")
 * 
 * @uses DbStoreAuthMenu
 */
class DbStoreAuthMenu extends Model
{

    /**
     *
     * @var string $component 组件
     *      @Column(name="component", type="char", length=150)
     *      @Required()
     */
    private $component;

    /**
     *
     * @var string $condition 条件
     *      @Column(name="condition", type="char", length=100)
     */
    private $condition;

    /**
     *
     * @var int $createTime 添加日期
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $fid 父级编号
     *      @Column(name="fid", type="integer", default=0)
     */
    private $fid;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 路由名称
     *      @Column(name="name", type="char", length=50)
     *      @Required()
     */
    private $name;

    /**
     *
     * @var string $path 路径
     *      @Column(name="path", type="char", length=50)
     */
    private $path;

    /**
     *
     * @var string $redirect 跳转路由
     *      @Column(name="redirect", type="char", length=50)
     */
    private $redirect;

    /**
     *
     * @var string $remark 备注
     *      @Column(name="remark", type="string", length=30)
     */
    private $remark;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="tinyint")
     */
    private $sort;

    /**
     *
     * @var int $status 状态【0隐藏，1显示】
     *      @Column(name="status", type="tinyint")
     *      @Required()
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新日期
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     * 组件
     * 
     * @param string $value            
     * @return $this
     */
    public function setComponent(string $value): self
    {
        $this->component = $value;
        
        return $this;
    }

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
     * 添加日期
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
     * 父级编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setFid(int $value): self
    {
        $this->fid = $value;
        
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
     * 路由名称
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
     * 路径
     * 
     * @param string $value            
     * @return $this
     */
    public function setPath(string $value): self
    {
        $this->path = $value;
        
        return $this;
    }

    /**
     * 跳转路由
     * 
     * @param string $value            
     * @return $this
     */
    public function setRedirect(string $value): self
    {
        $this->redirect = $value;
        
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
     * 状态【0隐藏，1显示】
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
     * 更新日期
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
     * 组件
     * 
     * @return string
     */
    public function getComponent()
    {
        return $this->component;
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
     * 添加日期
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 父级编号
     * 
     * @return int
     */
    public function getFid()
    {
        return $this->fid;
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
     * 路由名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 路径
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * 跳转路由
     * 
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
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
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 状态【0隐藏，1显示】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 更新日期
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
