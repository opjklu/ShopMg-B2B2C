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
 * 支付类型
 *
 * @Entity()
 * @Table(name="mg_pay_type")
 * 
 * @uses DbPayType
 */
class DbPayType extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
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
     * @var int $isDefault 是否默认
     *      @Column(name="is_default", type="tinyint", default=0)
     */
    private $isDefault;

    /**
     *
     * @var int $isSpecial 特殊支付方式【 0 不是 1 是】
     *      @Column(name="is_special", type="tinyint", default=0)
     */
    private $isSpecial;

    /**
     *
     * @var string $logo 支付logo
     *      @Column(name="logo", type="string", length=100, default="")
     */
    private $logo;

    /**
     *
     * @var int $status 是否开启【1开启 0 关闭】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var string $typeName 支付类型
     *      @Column(name="type_name", type="char", length=20)
     *      @Required()
     */
    private $typeName;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
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
     * 是否默认
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsDefault(int $value): self
    {
        $this->isDefault = $value;
        
        return $this;
    }

    /**
     * 特殊支付方式【 0 不是 1 是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsSpecial(int $value): self
    {
        $this->isSpecial = $value;
        
        return $this;
    }

    /**
     * 支付logo
     * 
     * @param string $value            
     * @return $this
     */
    public function setLogo(string $value): self
    {
        $this->logo = $value;
        
        return $this;
    }

    /**
     * 是否开启【1开启 0 关闭】
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
     * 支付类型
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
     * 是否默认
     * 
     * @return int
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * 特殊支付方式【 0 不是 1 是】
     * 
     * @return int
     */
    public function getIsSpecial()
    {
        return $this->isSpecial;
    }

    /**
     * 支付logo
     * 
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * 是否开启【1开启 0 关闭】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 支付类型
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
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
