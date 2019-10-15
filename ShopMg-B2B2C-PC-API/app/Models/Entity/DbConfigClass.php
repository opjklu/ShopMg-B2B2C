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
 * 配置项父类
 *
 * @Entity()
 * @Table(name="mg_config_class")
 * 
 * @uses DbConfigClass
 */
class DbConfigClass extends Model
{

    /**
     *
     * @var string $configClassName 分类配置名称
     *      @Column(name="config_class_name", type="string", length=50)
     */
    private $configClassName;

    /**
     *
     * @var string $createTime 创建时间
     *      @Column(name="create_time", type="string", length=20)
     */
    private $createTime;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isOpen 0=》启用配置， 1弃用配置
     *      @Column(name="is_open", type="smallint", default=0)
     */
    private $isOpen;

    /**
     *
     * @var int $pId 父级分类
     *      @Column(name="p_id", type="integer", default=0)
     */
    private $pId;

    /**
     *
     * @var string $updateTime 更新时间
     *      @Column(name="update_time", type="string", length=20)
     */
    private $updateTime;

    /**
     * 分类配置名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setConfigClassName(string $value): self
    {
        $this->configClassName = $value;
        
        return $this;
    }

    /**
     * 创建时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setCreateTime(string $value): self
    {
        $this->createTime = $value;
        
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
     * 0=》启用配置， 1弃用配置
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsOpen(int $value): self
    {
        $this->isOpen = $value;
        
        return $this;
    }

    /**
     * 父级分类
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
     * 更新时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setUpdateTime(string $value): self
    {
        $this->updateTime = $value;
        
        return $this;
    }

    /**
     * 分类配置名称
     * 
     * @return string
     */
    public function getConfigClassName()
    {
        return $this->configClassName;
    }

    /**
     * 创建时间
     * 
     * @return string
     */
    public function getCreateTime()
    {
        return $this->createTime;
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
     * 0=》启用配置， 1弃用配置
     * 
     * @return int
     */
    public function getIsOpen()
    {
        return $this->isOpen;
    }

    /**
     * 父级分类
     * 
     * @return int
     */
    public function getPId()
    {
        return $this->pId;
    }

    /**
     * 更新时间
     * 
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
