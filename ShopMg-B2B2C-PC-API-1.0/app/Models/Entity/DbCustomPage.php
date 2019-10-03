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
 * 自定义页面表
 *
 * @Entity()
 * @Table(name="mg_custom_page")
 * 
 * @uses DbCustomPage
 */
class DbCustomPage extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $groupId 自定义页面分类【编号】
     *      @Column(name="group_id", type="integer", default=0)
     */
    private $groupId;

    /**
     *
     * @var int $id id编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 文件名称
     *      @Column(name="name", type="string", length=50, default="")
     */
    private $name;

    /**
     *
     * @var string $path 静态页面路径
     *      @Column(name="path", type="string", length=50, default="")
     */
    private $path;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer", default=0)
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
     * 自定义页面分类【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setGroupId(int $value): self
    {
        $this->groupId = $value;
        
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
     * 文件名称
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
     * 静态页面路径
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
     * 自定义页面分类【编号】
     * 
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
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
     * 文件名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 静态页面路径
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
