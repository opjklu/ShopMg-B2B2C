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
 * 团购订单表
 *
 * @Entity()
 * @Table(name="mg_order_group")
 * 
 * @uses DbOrderGroup
 */
class DbOrderGroup extends Model
{

    /**
     *
     * @var int $addTime 添加时间
     *      @Column(name="add_time", type="integer")
     *      @Required()
     */
    private $addTime;

    /**
     *
     * @var int $editTime 修改时间
     *      @Column(name="edit_time", type="integer")
     */
    private $editTime;

    /**
     *
     * @var float $freights 总运费
     *      @Column(name="freights", type="float")
     */
    private $freights;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isDel 0正常1删除
     *      @Column(name="is_del", type="tinyint", default=0)
     */
    private $isDel;

    /**
     *
     * @var string $message 买家留言
     *      @Column(name="message", type="text", length=65535)
     */
    private $message;

    /**
     *
     * @var string $orderSnId 订单标识(订单号)
     *      @Column(name="order_sn_id", type="string", length=50, default="00000")
     */
    private $orderSnId;

    /**
     *
     * @var int $payTime 支付时间
     *      @Column(name="pay_time", type="integer")
     */
    private $payTime;

    /**
     *
     * @var float $priceNum 订单总价
     *      @Column(name="price_num", type="float")
     *      @Required()
     */
    private $priceNum;

    /**
     *
     * @var int $status 0待支付1待兑换2已兑换
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 添加时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setAddTime(int $value): self
    {
        $this->addTime = $value;
        
        return $this;
    }

    /**
     * 修改时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setEditTime(int $value): self
    {
        $this->editTime = $value;
        
        return $this;
    }

    /**
     * 总运费
     * 
     * @param float $value            
     * @return $this
     */
    public function setFreights(float $value): self
    {
        $this->freights = $value;
        
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
     * 0正常1删除
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsDel(int $value): self
    {
        $this->isDel = $value;
        
        return $this;
    }

    /**
     * 买家留言
     * 
     * @param string $value            
     * @return $this
     */
    public function setMessage(string $value): self
    {
        $this->message = $value;
        
        return $this;
    }

    /**
     * 订单标识(订单号)
     * 
     * @param string $value            
     * @return $this
     */
    public function setOrderSnId(string $value): self
    {
        $this->orderSnId = $value;
        
        return $this;
    }

    /**
     * 支付时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setPayTime(int $value): self
    {
        $this->payTime = $value;
        
        return $this;
    }

    /**
     * 订单总价
     * 
     * @param float $value            
     * @return $this
     */
    public function setPriceNum(float $value): self
    {
        $this->priceNum = $value;
        
        return $this;
    }

    /**
     * 0待支付1待兑换2已兑换
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
     * 店铺【编号】
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
     * 添加时间
     * 
     * @return int
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * 修改时间
     * 
     * @return int
     */
    public function getEditTime()
    {
        return $this->editTime;
    }

    /**
     * 总运费
     * 
     * @return float
     */
    public function getFreights()
    {
        return $this->freights;
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
     * 0正常1删除
     * 
     * @return int
     */
    public function getIsDel()
    {
        return $this->isDel;
    }

    /**
     * 买家留言
     * 
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * 订单标识(订单号)
     * 
     * @return mixed
     */
    public function getOrderSnId()
    {
        return $this->orderSnId;
    }

    /**
     * 支付时间
     * 
     * @return int
     */
    public function getPayTime()
    {
        return $this->payTime;
    }

    /**
     * 订单总价
     * 
     * @return float
     */
    public function getPriceNum()
    {
        return $this->priceNum;
    }

    /**
     * 0待支付1待兑换2已兑换
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺【编号】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
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
