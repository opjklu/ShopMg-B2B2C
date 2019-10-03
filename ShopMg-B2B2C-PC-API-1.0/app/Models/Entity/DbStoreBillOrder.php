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
 * 平台打款订单
 *
 * @Entity()
 * @Table(name="mg_store_bill_order")
 * 
 * @uses DbStoreBillOrder
 */
class DbStoreBillOrder extends Model
{

    /**
     *
     * @var int $adminId 操作人
     *      @Column(name="admin_id", type="integer", default=0)
     */
    private $adminId;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id 打款编号
     *      @Id()
     *      @Column(name="id", type="bigint")
     */
    private $id;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     *
     * @var float $widbatchFee 打款总金额
     *      @Column(name="widbatch_fee", type="float", default=0)
     */
    private $widbatchFee;

    /**
     *
     * @var string $widbatchNo 打款批次号
     *      @Column(name="widbatch_no", type="string", length=50)
     *      @Required()
     */
    private $widbatchNo;

    /**
     *
     * @var int $widbatchNum 付款笔数
     *      @Column(name="widbatch_num", type="integer")
     *      @Required()
     */
    private $widbatchNum;

    /**
     *
     * @var string $widdetailDescription 付款描述
     *      @Column(name="widdetail_description", type="string", length=200)
     *      @Required()
     */
    private $widdetailDescription;

    /**
     * 操作人
     * 
     * @param int $value            
     * @return $this
     */
    public function setAdminId(int $value): self
    {
        $this->adminId = $value;
        
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
     * 打款编号
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
     * 打款总金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setWidbatchFee(float $value): self
    {
        $this->widbatchFee = $value;
        
        return $this;
    }

    /**
     * 打款批次号
     * 
     * @param string $value            
     * @return $this
     */
    public function setWidbatchNo(string $value): self
    {
        $this->widbatchNo = $value;
        
        return $this;
    }

    /**
     * 付款笔数
     * 
     * @param int $value            
     * @return $this
     */
    public function setWidbatchNum(int $value): self
    {
        $this->widbatchNum = $value;
        
        return $this;
    }

    /**
     * 付款描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setWiddetailDescription(string $value): self
    {
        $this->widdetailDescription = $value;
        
        return $this;
    }

    /**
     * 操作人
     * 
     * @return int
     */
    public function getAdminId()
    {
        return $this->adminId;
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
     * 打款编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * 打款总金额
     * 
     * @return mixed
     */
    public function getWidbatchFee()
    {
        return $this->widbatchFee;
    }

    /**
     * 打款批次号
     * 
     * @return string
     */
    public function getWidbatchNo()
    {
        return $this->widbatchNo;
    }

    /**
     * 付款笔数
     * 
     * @return int
     */
    public function getWidbatchNum()
    {
        return $this->widbatchNum;
    }

    /**
     * 付款描述
     * 
     * @return string
     */
    public function getWiddetailDescription()
    {
        return $this->widdetailDescription;
    }
}
