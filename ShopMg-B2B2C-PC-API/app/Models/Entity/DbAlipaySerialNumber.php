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
 * 支付宝流水号【交易号】
 *
 * @Entity()
 * @Table(name="mg_alipay_serial_number")
 * 
 * @uses DbAlipaySerialNumber
 */
class DbAlipaySerialNumber extends Model
{

    /**
     *
     * @var string $alipayCount 支付宝流水号
     *      @Column(name="alipay_count", type="string", length=100, default="")
     */
    private $alipayCount;

    /**
     *
     * @var int $id 支付宝订单退款编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderId 订单号
     *      @Column(name="order_id", type="integer", default=0)
     */
    private $orderId;

    /**
     *
     * @var int $type 支付类型 0 商品支付，1套餐支付，2积分支付，3开店支付，4余额充值
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     * 支付宝流水号
     * 
     * @param string $value            
     * @return $this
     */
    public function setAlipayCount(string $value): self
    {
        $this->alipayCount = $value;
        
        return $this;
    }

    /**
     * 支付宝订单退款编号
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
     * 订单号
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
     * 支付类型 0 商品支付，1套餐支付，2积分支付，3开店支付，4余额充值
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
     * 支付宝流水号
     * 
     * @return string
     */
    public function getAlipayCount()
    {
        return $this->alipayCount;
    }

    /**
     * 支付宝订单退款编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 订单号
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 支付类型 0 商品支付，1套餐支付，2积分支付，3开店支付，4余额充值
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}
