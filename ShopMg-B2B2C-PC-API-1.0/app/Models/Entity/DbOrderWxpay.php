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
 * 微信订单标志码
 *
 * @Entity()
 * @Table(name="mg_order_wxpay")
 * 
 * @uses DbOrderWxpay
 */
class DbOrderWxpay extends Model
{

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderId @Column(name="order_id", type="integer")
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var int $status 0支付失败 1 支付成功
     *      @Column(name="status", type="tinyint")
     *      @Required()
     */
    private $status;

    /**
     *
     * @var int $type 支付类型 0 商品支付，1套餐支付，2积分支付,3开店支付，4余额充值
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var string $wxPayId 支付码
     *      @Column(name="wx_pay_id", type="string", length=50)
     *      @Required()
     */
    private $wxPayId;

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
     * 0支付失败 1 支付成功
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
     * 支付类型 0 商品支付，1套餐支付，2积分支付,3开店支付，4余额充值
     * 
     * @param int $value            
     * @return $this
     */
    public function setType(int $value): self
    {
        $this->type = $value;
        
        return $this;
    }

    /**
     * 支付码
     * 
     * @param string $value            
     * @return $this
     */
    public function setWxPayId(string $value): self
    {
        $this->wxPayId = $value;
        
        return $this;
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
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 0支付失败 1 支付成功
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 支付类型 0 商品支付，1套餐支付，2积分支付,3开店支付，4余额充值
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 支付码
     * 
     * @return string
     */
    public function getWxPayId()
    {
        return $this->wxPayId;
    }
}
