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
 * 会员充值记录
 *
 * @Entity()
 * @Table(name="mg_recharge")
 * 
 * @uses DbRecharge
 */
class DbRecharge extends Model
{

    /**
     *
     * @var float $account 充值金额
     *      @Column(name="account", type="float", default=0)
     */
    private $account;

    /**
     *
     * @var int $ctime 充值时间
     *      @Column(name="ctime", type="integer", default=0)
     */
    private $ctime;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="bigint")
     */
    private $id;

    /**
     *
     * @var string $orderSn 充值单号
     *      @Column(name="order_sn", type="string", length=30)
     *      @Required()
     */
    private $orderSn;

    /**
     *
     * @var int $payId 支付方式
     *      @Column(name="pay_id", type="integer", default=0)
     */
    private $payId;

    /**
     *
     * @var int $payStatus 充值状态【0:待支付 1:充值成功 2:交易关闭】
     *      @Column(name="pay_status", type="tinyint", default=0)
     */
    private $payStatus;

    /**
     *
     * @var int $payTime 支付时间
     *      @Column(name="pay_time", type="integer", default=0)
     */
    private $payTime;

    /**
     *
     * @var int $payType 设备类型【0pc,1手机】
     *      @Column(name="pay_type", type="tinyint", default=0)
     */
    private $payType;

    /**
     *
     * @var int $userId 会员ID
     *      @Column(name="user_id", type="bigint")
     *      @Required()
     */
    private $userId;

    /**
     * 充值金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setAccount(float $value): self
    {
        $this->account = $value;
        
        return $this;
    }

    /**
     * 充值时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setCtime(int $value): self
    {
        $this->ctime = $value;
        
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
     * 充值单号
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
     * 支付方式
     * 
     * @param int $value            
     * @return $this
     */
    public function setPayId(int $value): self
    {
        $this->payId = $value;
        
        return $this;
    }

    /**
     * 充值状态【0:待支付 1:充值成功 2:交易关闭】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPayStatus(int $value): self
    {
        $this->payStatus = $value;
        
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
     * 设备类型【0pc,1手机】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPayType(int $value): self
    {
        $this->payType = $value;
        
        return $this;
    }

    /**
     * 会员ID
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
     * 充值金额
     * 
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * 充值时间
     * 
     * @return int
     */
    public function getCtime()
    {
        return $this->ctime;
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
     * 充值单号
     * 
     * @return string
     */
    public function getOrderSn()
    {
        return $this->orderSn;
    }

    /**
     * 支付方式
     * 
     * @return int
     */
    public function getPayId()
    {
        return $this->payId;
    }

    /**
     * 充值状态【0:待支付 1:充值成功 2:交易关闭】
     * 
     * @return int
     */
    public function getPayStatus()
    {
        return $this->payStatus;
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
     * 设备类型【0pc,1手机】
     * 
     * @return int
     */
    public function getPayType()
    {
        return $this->payType;
    }

    /**
     * 会员ID
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
