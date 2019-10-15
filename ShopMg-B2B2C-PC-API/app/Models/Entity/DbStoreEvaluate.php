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
 * 店铺评分表
 *
 * @Entity()
 * @Table(name="mg_store_evaluate")
 * 
 * @uses DbStoreEvaluate
 */
class DbStoreEvaluate extends Model
{

    /**
     *
     * @var int $createTime 评价时间
     *      @Column(name="create_time", type="integer")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var float $deliverycredit 发货速度评分
     *      @Column(name="deliverycredit", type="float", default=5)
     */
    private $deliverycredit;

    /**
     *
     * @var float $desccredit 描述相符评分
     *      @Column(name="desccredit", type="float", default=5)
     */
    private $desccredit;

    /**
     *
     * @var int $id 评价ID
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $memberId 买家编号
     *      @Column(name="member_id", type="integer")
     *      @Required()
     */
    private $memberId;

    /**
     *
     * @var int $orderId 订单ID
     *      @Column(name="order_id", type="integer")
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var float $servicecredit 服务态度评分
     *      @Column(name="servicecredit", type="float", default=5)
     */
    private $servicecredit;

    /**
     *
     * @var int $storeId 店铺编号
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     * 评价时间
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
     * 发货速度评分
     * 
     * @param float $value            
     * @return $this
     */
    public function setDeliverycredit(float $value): self
    {
        $this->deliverycredit = $value;
        
        return $this;
    }

    /**
     * 描述相符评分
     * 
     * @param float $value            
     * @return $this
     */
    public function setDesccredit(float $value): self
    {
        $this->desccredit = $value;
        
        return $this;
    }

    /**
     * 评价ID
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
     * 买家编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setMemberId(int $value): self
    {
        $this->memberId = $value;
        
        return $this;
    }

    /**
     * 订单ID
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
     * 服务态度评分
     * 
     * @param float $value            
     * @return $this
     */
    public function setServicecredit(float $value): self
    {
        $this->servicecredit = $value;
        
        return $this;
    }

    /**
     * 店铺编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreId(int $value): self
    {
        $this->storeId = $value;
        
        return $this;
    }

    /**
     * 评价时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 发货速度评分
     * 
     * @return mixed
     */
    public function getDeliverycredit()
    {
        return $this->deliverycredit;
    }

    /**
     * 描述相符评分
     * 
     * @return mixed
     */
    public function getDesccredit()
    {
        return $this->desccredit;
    }

    /**
     * 评价ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 买家编号
     * 
     * @return int
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * 订单ID
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 服务态度评分
     * 
     * @return mixed
     */
    public function getServicecredit()
    {
        return $this->servicecredit;
    }

    /**
     * 店铺编号
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
