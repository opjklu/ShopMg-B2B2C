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
 * 中国地区表
 *
 * @Entity()
 * @Table(name="mg_region")
 * 
 * @uses DbRegion
 */
class DbRegion extends Model
{

    /**
     *
     * @var int $displayorder 排序
     *      @Column(name="displayorder", type="integer")
     *      @Required()
     */
    private $displayorder;

    /**
     *
     * @var int $id 地区编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 名称
     *      @Column(name="name", type="string", length=255)
     *      @Required()
     */
    private $name;

    /**
     *
     * @var int $parentid 上级id
     *      @Column(name="parentid", type="integer")
     *      @Required()
     */
    private $parentid;

    /**
     *
     * @var int $type 类型
     *      @Column(name="type", type="integer")
     *      @Required()
     */
    private $type;

    /**
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setDisplayorder(int $value): self
    {
        $this->displayorder = $value;
        
        return $this;
    }

    /**
     * 地区编号
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
     * 名称
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
     * 上级id
     * 
     * @param int $value            
     * @return $this
     */
    public function setParentid(int $value): self
    {
        $this->parentid = $value;
        
        return $this;
    }

    /**
     * 类型
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
     * 排序
     * 
     * @return int
     */
    public function getDisplayorder()
    {
        return $this->displayorder;
    }

    /**
     * 地区编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 上级id
     * 
     * @return int
     */
    public function getParentid()
    {
        return $this->parentid;
    }

    /**
     * 类型
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}
