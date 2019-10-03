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
 * 支付宝打款凭证
 *
 * @Entity()
 * @Table(name="mg_store_bill_order_alipay_number")
 * 
 * @uses DbStoreBillOrderAlipayNumber
 */
class DbStoreBillOrderAlipayNumber extends Model
{

    /**
     *
     * @var string $bizNo 商户转账唯一订单号
     *      @Column(name="biz_no", type="char", length=64)
     *      @Required()
     */
    private $bizNo;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="bigint")
     */
    private $id;

    /**
     *
     * @var int $orderId 商户打款订单编号
     *      @Column(name="order_id", type="bigint")
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var string $orderSn 支付宝转账单据号
     *      @Column(name="order_sn", type="char", length=64)
     *      @Required()
     */
    private $orderSn;

    /**
     *
     * @var string $payDate 支付时间
     *      @Column(name="pay_date", type="datetime")
     *      @Required()
     */
    private $payDate;

    /**
     * 商户转账唯一订单号
     * 
     * @param string $value            
     * @return $this
     */
    public function setBizNo(string $value): self
    {
        $this->bizNo = $value;
        
        return $this;
    }

    /**
     * 编号
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
     * 商户打款订单编号
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
     * 支付宝转账单据号
     * 
     * @param string $value            
     * @return $this
     */
    public function setOrderSn(string $value): self
    {
        $this->orderSn = $value;
        
        return $this;
    }

    /**
     * 支付时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setPayDate(string $value): self
    {
        $this->payDate = $value;
        
        return $this;
    }

    /**
     * 商户转账唯一订单号
     * 
     * @return string
     */
    public function getBizNo()
    {
        return $this->bizNo;
    }

    /**
     * 编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 商户打款订单编号
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 支付宝转账单据号
     * 
     * @return string
     */
    public function getOrderSn()
    {
        return $this->orderSn;
    }

    /**
     * 支付时间
     * 
     * @return string
     */
    public function getPayDate()
    {
        return $this->payDate;
    }
}
