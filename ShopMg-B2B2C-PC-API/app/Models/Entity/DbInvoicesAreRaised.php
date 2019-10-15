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
 * 发票抬头表
 *
 * @Entity()
 * @Table(name="mg_invoices_are_raised")
 * 
 * @uses DbInvoicesAreRaised
 */
class DbInvoicesAreRaised extends Model
{

    /**
     *
     * @var int $createTime @Column(name="create_time", type="integer")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $def 是否默认 0否 1 是
     *      @Column(name="def", type="tinyint", default=0)
     */
    private $def;

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 单位名称
     *      @Column(name="name", type="string", length=50)
     *      @Required()
     */
    private $name;

    /**
     *
     * @var int $status 抬头类型【0 个人 1单位】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $updateTime @Column(name="update_time", type="integer")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
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
     * 是否默认 0否 1 是
     * 
     * @param int $value            
     * @return $this
     */
    public function setDef(int $value): self
    {
        $this->def = $value;
        
        return $this;
    }

    /**
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
     * 单位名称
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
     * 抬头类型【0 个人 1单位】
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
     * 用户
     * 
     * @param int $value            
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->userId = $value;
        
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 是否默认 0否 1 是
     * 
     * @return int
     */
    public function getDef()
    {
        return $this->def;
    }

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 单位名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 抬头类型【0 个人 1单位】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 用户
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
