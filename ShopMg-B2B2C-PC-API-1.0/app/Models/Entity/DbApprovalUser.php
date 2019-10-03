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
 * 用户审核通过存贮信息表
 *
 * @Entity()
 * @Table(name="mg_approval_user")
 * 
 * @uses DbApprovalUser
 */
class DbApprovalUser extends Model
{

    /**
     *
     * @var int $approvalTime 授权日期
     *      @Column(name="approval_time", type="integer", default=0)
     */
    private $approvalTime;

    /**
     *
     * @var int $beOverdue 有效期
     *      @Column(name="be_overdue", type="integer", default=0)
     */
    private $beOverdue;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $effective 是否有效【0 无效，1有效】
     *      @Column(name="effective", type="tinyint", default=1)
     */
    private $effective;

    /**
     *
     * @var int $enterpriseId 审批编号
     *      @Column(name="enterprise_id", type="integer", default=0)
     */
    private $enterpriseId;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isExpired 是否过期【0：过期，1未过期】
     *      @Column(name="is_expired", type="tinyint", default=1)
     */
    private $isExpired;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer", default=0)
     */
    private $updateTime;

    /**
     * 授权日期
     * 
     * @param int $value            
     * @return $this
     */
    public function setApprovalTime(int $value): self
    {
        $this->approvalTime = $value;
        
        return $this;
    }

    /**
     * 有效期
     * 
     * @param int $value            
     * @return $this
     */
    public function setBeOverdue(int $value): self
    {
        $this->beOverdue = $value;
        
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
     * 是否有效【0 无效，1有效】
     * 
     * @param int $value            
     * @return $this
     */
    public function setEffective(int $value): self
    {
        $this->effective = $value;
        
        return $this;
    }

    /**
     * 审批编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setEnterpriseId(int $value): self
    {
        $this->enterpriseId = $value;
        
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
     * 是否过期【0：过期，1未过期】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsExpired(int $value): self
    {
        $this->isExpired = $value;
        
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
     * 授权日期
     * 
     * @return int
     */
    public function getApprovalTime()
    {
        return $this->approvalTime;
    }

    /**
     * 有效期
     * 
     * @return int
     */
    public function getBeOverdue()
    {
        return $this->beOverdue;
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
     * 是否有效【0 无效，1有效】
     * 
     * @return mixed
     */
    public function getEffective()
    {
        return $this->effective;
    }

    /**
     * 审批编号
     * 
     * @return int
     */
    public function getEnterpriseId()
    {
        return $this->enterpriseId;
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
     * 是否过期【0：过期，1未过期】
     * 
     * @return mixed
     */
    public function getIsExpired()
    {
        return $this->isExpired;
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
