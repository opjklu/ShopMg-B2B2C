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
 * 配置项子表
 *
 * @Entity()
 * @Table(name="mg_config_children")
 * 
 * @uses DbConfigChildren
 */
class DbConfigChildren extends Model
{

    /**
     *
     * @var int $configClassId 内容分类编号
     *      @Column(name="config_class_id", type="integer", default=1)
     */
    private $configClassId;

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
     * @var string $showType 展示类型
     *      @Column(name="show_type", type="string", length=20, default="input")
     */
    private $showType;

    /**
     *
     * @var string $type 输入框对应的类型
     *      @Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     *
     * @var string $typeName 对应的name值
     *      @Column(name="type_name", type="string", length=50)
     */
    private $typeName;

    /**
     *
     * @var string $updateTime 更新时间
     *      @Column(name="update_time", type="string", length=20)
     */
    private $updateTime;

    /**
     * 内容分类编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setConfigClassId(int $value): self
    {
        $this->configClassId = $value;
        
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
     * 展示类型
     * 
     * @param string $value            
     * @return $this
     */
    public function setShowType(string $value): self
    {
        $this->showType = $value;
        
        return $this;
    }

    /**
     * 输入框对应的类型
     * 
     * @param string $value            
     * @return $this
     */
    public function setType(string $value): self
    {
        $this->type = $value;
        
        return $this;
    }

    /**
     * 对应的name值
     * 
     * @param string $value            
     * @return $this
     */
    public function setTypeName(string $value): self
    {
        $this->typeName = $value;
        
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
     * 内容分类编号
     * 
     * @return mixed
     */
    public function getConfigClassId()
    {
        return $this->configClassId;
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
     * 展示类型
     * 
     * @return mixed
     */
    public function getShowType()
    {
        return $this->showType;
    }

    /**
     * 输入框对应的类型
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 对应的name值
     * 
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
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
