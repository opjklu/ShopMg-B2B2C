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
 * 提现表
 *
 * @Entity()
 * @Table(name="mg_cash_withdrawal")
 * 
 * @uses DbCashWithdrawal
 */
class DbCashWithdrawal extends Model
{

    /**
     *
     * @var string $account 提现账号
     *      @Column(name="account", type="string", length=50, default="0")
     */
    private $account;

    /**
     *
     * @var string $alipayOrder 支付宝订单号
     *      @Column(name="alipay_order", type="string", length=50, default="")
     */
    private $alipayOrder;

    /**
     *
     * @var int $approvalId 审核人【编号】
     *      @Column(name="approval_id", type="integer", default=0)
     */
    private $approvalId;

    /**
     *
     * @var string $approvalMessage 审核消息
     *      @Column(name="approval_message", type="string", length=100, default="")
     */
    private $approvalMessage;

    /**
     *
     * @var string $approvalName 审核人【账号，适当冗余】
     *      @Column(name="approval_name", type="string", length=50, default="")
     */
    private $approvalName;

    /**
     *
     * @var int $cashType 提现方式【例如支付宝】
     *      @Column(name="cash_type", type="tinyint", default=0)
     */
    private $cashType;

    /**
     *
     * @var int $createTime 添加时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var float $money 提现金额
     *      @Column(name="money", type="decimal", default=0)
     */
    private $money;

    /**
     *
     * @var string $orderSn 提现订单号
     *      @Column(name="order_sn", type="string", length=50, default="")
     */
    private $orderSn;

    /**
     *
     * @var int $platformType 平台类型【0 PC， 1 mobile 2微商城】
     *      @Column(name="platform_type", type="tinyint", default=0)
     */
    private $platformType;

    /**
     *
     * @var int $status 状态【0 审核中，1 审核成功，2 审核失败，3 提现成功】
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $successTime 提现完成时间
     *      @Column(name="success_time", type="bigint", default=0)
     */
    private $successTime;

    /**
     *
     * @var int $updateTime 最后修改时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户【id】
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     * 提现账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setAccount(string $value): self
    {
        $this->account = $value;
        
        return $this;
    }

    /**
     * 支付宝订单号
     * 
     * @param string $value            
     * @return $this
     */
    public function setAlipayOrder(string $value): self
    {
        $this->alipayOrder = $value;
        
        return $this;
    }

    /**
     * 审核人【编号】
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
     * 审核消息
     * 
     * @param string $value            
     * @return $this
     */
    public function setApprovalMessage(string $value): self
    {
        $this->approvalMessage = $value;
        
        return $this;
    }

    /**
     * 审核人【账号，适当冗余】
     * 
     * @param string $value            
     * @return $this
     */
    public function setApprovalName(string $value): self
    {
        $this->approvalName = $value;
        
        return $this;
    }

    /**
     * 提现方式【例如支付宝】
     * 
     * @param int $value            
     * @return $this
     */
    public function setCashType(int $value): self
    {
        $this->cashType = $value;
        
        return $this;
    }

    /**
     * 添加时间
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
     * 提现金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setMoney(float $value): self
    {
        $this->money = $value;
        
        return $this;
    }

    /**
     * 提现订单号
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
     * 平台类型【0 PC， 1 mobile 2微商城】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPlatformType(int $value): self
    {
        $this->platformType = $value;
        
        return $this;
    }

    /**
     * 状态【0 审核中，1 审核成功，2 审核失败，3 提现成功】
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
     * 提现完成时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setSuccessTime(int $value): self
    {
        $this->successTime = $value;
        
        return $this;
    }

    /**
     * 最后修改时间
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
     * 用户【id】
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
     * 提现账号
     * 
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * 支付宝订单号
     * 
     * @return string
     */
    public function getAlipayOrder()
    {
        return $this->alipayOrder;
    }

    /**
     * 审核人【编号】
     * 
     * @return int
     */
    public function getApprovalId()
    {
        return $this->approvalId;
    }

    /**
     * 审核消息
     * 
     * @return string
     */
    public function getApprovalMessage()
    {
        return $this->approvalMessage;
    }

    /**
     * 审核人【账号，适当冗余】
     * 
     * @return string
     */
    public function getApprovalName()
    {
        return $this->approvalName;
    }

    /**
     * 提现方式【例如支付宝】
     * 
     * @return int
     */
    public function getCashType()
    {
        return $this->cashType;
    }

    /**
     * 添加时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
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
     * 提现金额
     * 
     * @return mixed
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * 提现订单号
     * 
     * @return string
     */
    public function getOrderSn()
    {
        return $this->orderSn;
    }

    /**
     * 平台类型【0 PC， 1 mobile 2微商城】
     * 
     * @return int
     */
    public function getPlatformType()
    {
        return $this->platformType;
    }

    /**
     * 状态【0 审核中，1 审核成功，2 审核失败，3 提现成功】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 提现完成时间
     * 
     * @return int
     */
    public function getSuccessTime()
    {
        return $this->successTime;
    }

    /**
     * 最后修改时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 用户【id】
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
