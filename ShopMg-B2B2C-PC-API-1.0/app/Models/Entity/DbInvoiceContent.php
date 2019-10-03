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
 * 发票内容表
 *
 * @Entity()
 * @Table(name="mg_invoice_content")
 * 
 * @uses DbInvoiceContent
 */
class DbInvoiceContent extends Model
{

    /**
     *
     * @var int $createTime @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id 发票内容编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 内容名称
     *      @Column(name="name", type="string", length=50, default="")
     */
    private $name;

    /**
     *
     * @var int $status 是否启用【0不，1是】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer", default=0)
     */
    private $updateTime;

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
     * 发票内容编号
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
     * 内容名称
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
     * 是否启用【0不，1是】
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
     *
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 发票内容编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 内容名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 是否启用【0不，1是】
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
