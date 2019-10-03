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
 * 套餐订单发票表
 *
 * @Entity()
 * @Table(name="mg_order_package_invoice")
 * 
 * @uses DbOrderPackageInvoice
 */
class DbOrderPackageInvoice extends Model
{

    /**
     *
     * @var int $contentId 发票内容
     *      @Column(name="content_id", type="integer")
     *      @Required()
     */
    private $contentId;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $id 发票id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderId 订单编号
     *      @Column(name="order_id", type="integer")
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var int $raisedId 发票抬头【编号】
     *      @Column(name="raised_id", type="integer")
     *      @Required()
     */
    private $raisedId;

    /**
     *
     * @var string $remarks 备注
     *      @Column(name="remarks", type="string", length=200)
     */
    private $remarks;

    /**
     *
     * @var int $typeId 发票类型
     *      @Column(name="type_id", type="tinyint")
     *      @Required()
     */
    private $typeId;

    /**
     *
     * @var int $updateTime 修改日期
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * 发票内容
     * 
     * @param int $value            
     * @return $this
     */
    public function setContentId(int $value): self
    {
        $this->contentId = $value;
        
        return $this;
    }

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
     * 发票id
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
     * 订单编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderId(int $value): self
    {
        $this->orderId = $value;
        
        return $this;
    }

    /**
     * 发票抬头【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setRaisedId(int $value): self
    {
        $this->raisedId = $value;
        
        return $this;
    }

    /**
     * 备注
     * 
     * @param string $value            
     * @return $this
     */
    public function setRemarks(string $value): self
    {
        $this->remarks = $value;
        
        return $this;
    }

    /**
     * 发票类型
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
     * 修改日期
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
     * 用户id
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
     * 发票内容
     * 
     * @return int
     */
    public function getContentId()
    {
        return $this->contentId;
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
     * 发票id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 订单编号
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 发票抬头【编号】
     * 
     * @return int
     */
    public function getRaisedId()
    {
        return $this->raisedId;
    }

    /**
     * 备注
     * 
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * 发票类型
     * 
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * 修改日期
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 用户id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
