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
 * @Table(name="mg_store_bill_order_store_data")
 * 
 * @uses DbStoreBillOrderStoreData
 */
class DbStoreBillOrderStoreData extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var float $eachFee 当前打款金额
     *      @Column(name="each_fee", type="float", default=0)
     */
    private $eachFee;

    /**
     *
     * @var int $id 打款编号
     *      @Id()
     *      @Column(name="id", type="bigint")
     */
    private $id;

    /**
     *
     * @var int $orderId 打款编号
     *      @Column(name="order_id", type="bigint")
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var int $storeId 商家【编号】
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

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
     * 当前打款金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setEachFee(float $value): self
    {
        $this->eachFee = $value;
        
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
     * 打款编号
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
     * 商家【编号】
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
     * 当前打款金额
     * 
     * @return mixed
     */
    public function getEachFee()
    {
        return $this->eachFee;
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
     * 打款编号
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 商家【编号】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
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
