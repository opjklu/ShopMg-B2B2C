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
 * 商品类型表
 *
 * @Entity()
 * @Table(name="mg_goods_type")
 * 
 * @uses DbGoodsType
 */
class DbGoodsType extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
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
     * @var string $name 商品类型名称
     *      @Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     *
     * @var int $status 显示状态：1显示 0不显示
     *      @Column(name="status", type="integer")
     */
    private $status;

    /**
     *
     * @var int $updateTime 最后一次修改时间
     *      @Column(name="update_time", type="integer")
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
     * 商品类型名称
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
     * 显示状态：1显示 0不显示
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
     * 最后一次修改时间
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
     * id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 商品类型名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 显示状态：1显示 0不显示
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 最后一次修改时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
