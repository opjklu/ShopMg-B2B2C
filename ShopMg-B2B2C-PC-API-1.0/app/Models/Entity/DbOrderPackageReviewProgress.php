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
 * 套餐订单审核进度查询
 *
 * @Entity()
 * @Table(name="mg_order_package_review_progress")
 * 
 * @uses DbOrderPackageReviewProgress
 */
class DbOrderPackageReviewProgress extends Model
{

    /**
     *
     * @var string $approvalContent 审核内容
     *      @Column(name="approval_content", type="string", length=100)
     *      @Required()
     */
    private $approvalContent;

    /**
     *
     * @var int $approvalId 审核人
     *      @Column(name="approval_id", type="integer")
     *      @Required()
     */
    private $approvalId;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $returnId 商品退货【编号】
     *      @Column(name="return_id", type="integer", default=0)
     */
    private $returnId;

    /**
     *
     * @var int $status 状态 【0默认1审核成功2审核失败】
     *      @Column(name="status", type="tinyint")
     *      @Required()
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     * 审核内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setApprovalContent(string $value): self
    {
        $this->approvalContent = $value;
        
        return $this;
    }

    /**
     * 审核人
     * 
     * @param int $value            
     * @return $this
     */
    public function setApprovalId(int $value): self
    {
        $this->approvalId = $value;
        
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
     * 商品退货【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setReturnId(int $value): self
    {
        $this->returnId = $value;
        
        return $this;
    }

    /**
     * 状态 【0默认1审核成功2审核失败】
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
     * 审核内容
     * 
     * @return string
     */
    public function getApprovalContent()
    {
        return $this->approvalContent;
    }

    /**
     * 审核人
     * 
     * @return int
     */
    public function getApprovalId()
    {
        return $this->approvalId;
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
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 商品退货【编号】
     * 
     * @return int
     */
    public function getReturnId()
    {
        return $this->returnId;
    }

    /**
     * 状态 【0默认1审核成功2审核失败】
     * 
     * @return int
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
