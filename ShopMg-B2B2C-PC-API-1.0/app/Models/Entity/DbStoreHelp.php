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
 * 店铺帮助内容表
 *
 * @Entity()
 * @Table(name="mg_store_help")
 * 
 * @uses DbStoreHelp
 */
class DbStoreHelp extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var string $helpUrl 跳转链接
     *      @Column(name="help_url", type="string", length=100, default="")
     */
    private $helpUrl;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $info 帮助内容
     *      @Column(name="info", type="text", length=65535)
     */
    private $info;

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
     * @var string $title 标题
     *      @Column(name="title", type="string", length=100)
     *      @Required()
     */
    private $title;

    /**
     *
     * @var int $typeId 帮助类型
     *      @Column(name="type_id", type="integer")
     *      @Required()
     */
    private $typeId;

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
     * 跳转链接
     * 
     * @param string $value            
     * @return $this
     */
    public function setHelpUrl(string $value): self
    {
        $this->helpUrl = $value;
        
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
     * 帮助内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setInfo(string $value): self
    {
        $this->info = $value;
        
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
     * 帮助类型
     * 
     * @param int $value            
     * @return $this
     */
    public function setTypeId(int $value): self
    {
        $this->typeId = $value;
        
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
     * 跳转链接
     * 
     * @return string
     */
    public function getHelpUrl()
    {
        return $this->helpUrl;
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
     * 帮助内容
     * 
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
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
     * 标题
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 帮助类型
     * 
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
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
