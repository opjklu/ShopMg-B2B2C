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
 * 系统配置值表
 *
 * @Entity()
 * @Table(name="mg_system_config")
 * 
 * @uses DbSystemConfig
 */
class DbSystemConfig extends Model
{

    /**
     *
     * @var int $classId 所属父级分类编号
     *      @Column(name="class_id", type="integer")
     */
    private $classId;

    /**
     *
     * @var string $configValue 配置值
     *      @Column(name="config_value", type="char", length=80)
     */
    private $configValue;

    /**
     *
     * @var string $createTime 创建时间
     *      @Column(name="create_time", type="string", length=20)
     */
    private $createTime;

    /**
     *
     * @var int $currentId 当前配置分类【编号】
     *      @Column(name="current_id", type="integer", default=0)
     */
    private $currentId;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $key 子配置键名
     *      @Column(name="key", type="char", length=80, default="")
     */
    private $key;

    /**
     *
     * @var string $parentKey 父级key
     *      @Column(name="parent_key", type="string", length=50, default="")
     */
    private $parentKey;

    /**
     *
     * @var string $updateTime 更新时间
     *      @Column(name="update_time", type="string", length=20)
     */
    private $updateTime;

    /**
     * 所属父级分类编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setClassId(int $value): self
    {
        $this->classId = $value;
        
        return $this;
    }

    /**
     * 配置值
     * 
     * @param string $value            
     * @return $this
     */
    public function setConfigValue(string $value): self
    {
        $this->configValue = $value;
        
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
     * 当前配置分类【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setCurrentId(int $value): self
    {
        $this->currentId = $value;
        
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
     * 子配置键名
     * 
     * @param string $value            
     * @return $this
     */
    public function setKey(string $value): self
    {
        $this->key = $value;
        
        return $this;
    }

    /**
     * 父级key
     * 
     * @param string $value            
     * @return $this
     */
    public function setParentKey(string $value): self
    {
        $this->parentKey = $value;
        
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
     * 所属父级分类编号
     * 
     * @return int
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * 配置值
     * 
     * @return string
     */
    public function getConfigValue()
    {
        return $this->configValue;
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
     * 当前配置分类【编号】
     * 
     * @return int
     */
    public function getCurrentId()
    {
        return $this->currentId;
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
     * 子配置键名
     * 
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 父级key
     * 
     * @return string
     */
    public function getParentKey()
    {
        return $this->parentKey;
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
