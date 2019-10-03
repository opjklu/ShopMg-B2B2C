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
 * 帮助类型表
 *
 * @Entity()
 * @Table(name="mg_help_type")
 * 
 * @uses DbHelpType
 */
class DbHelpType extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var string $helpCode 调用编号【auto的可删除】
     *      @Column(name="help_code", type="string", length=10, default="auto")
     */
    private $helpCode;

    /**
     *
     * @var int $id 类型ID
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 类型名称
     *      @Column(name="name", type="string", length=50)
     *      @Required()
     */
    private $name;

    /**
     *
     * @var int $pId 父及编号
     *      @Column(name="p_id", type="integer", default=0)
     */
    private $pId;

    /**
     *
     * @var int $pageShow 页面类型【0为店铺,1为会员】
     *      @Column(name="page_show", type="tinyint", default=0)
     */
    private $pageShow;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="tinyint", default=255)
     */
    private $sort;

    /**
     *
     * @var int $status 是否显示【0为否,1为是,默认为1】
     *      @Column(name="status", type="tinyint", default=1)
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
     * 调用编号【auto的可删除】
     * 
     * @param string $value            
     * @return $this
     */
    public function setHelpCode(string $value): self
    {
        $this->helpCode = $value;
        
        return $this;
    }

    /**
     * 类型ID
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
     * 类型名称
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
     * 父及编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setPId(int $value): self
    {
        $this->pId = $value;
        
        return $this;
    }

    /**
     * 页面类型【0为店铺,1为会员】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPageShow(int $value): self
    {
        $this->pageShow = $value;
        
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
     * 是否显示【0为否,1为是,默认为1】
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
     * 调用编号【auto的可删除】
     * 
     * @return mixed
     */
    public function getHelpCode()
    {
        return $this->helpCode;
    }

    /**
     * 类型ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 类型名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 父及编号
     * 
     * @return int
     */
    public function getPId()
    {
        return $this->pId;
    }

    /**
     * 页面类型【0为店铺,1为会员】
     * 
     * @return int
     */
    public function getPageShow()
    {
        return $this->pageShow;
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
     * 是否显示【0为否,1为是,默认为1】
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
