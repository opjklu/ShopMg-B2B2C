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
 * 支付配置
 *
 * @Entity()
 * @Table(name="mg_pay")
 * 
 * @uses DbPay
 */
class DbPay extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     */
    private $createTime;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $mchid 受理人编号或收款方支付宝账号【一般情况下与合作这身份id一样】
     *      @Column(name="mchid", type="string", length=20)
     */
    private $mchid;

    /**
     *
     * @var string $notifyUrl 异步通知url
     *      @Column(name="notify_url", type="string", length=100)
     *      @Required()
     */
    private $notifyUrl;

    /**
     *
     * @var string $openId 微信openID
     *      @Column(name="open_id", type="string", length=50)
     */
    private $openId;

    /**
     *
     * @var string $payAccount 支付账号或APP_ID
     *      @Column(name="pay_account", type="string", length=50)
     */
    private $payAccount;

    /**
     *
     * @var string $payKey 支付秘钥
     *      @Column(name="pay_key", type="string", length=50)
     */
    private $payKey;

    /**
     *
     * @var string $payName 支付类名【不可更改】
     *      @Column(name="pay_name", type="string", length=50)
     */
    private $payName;

    /**
     *
     * @var int $payTypeId 支付类型【编号】
     *      @Column(name="pay_type_id", type="integer", default=0)
     */
    private $payTypeId;

    /**
     *
     * @var string $privatePem 私钥
     *      @Column(name="private_pem", type="text", length=65535)
     */
    private $privatePem;

    /**
     *
     * @var string $publicPem 公钥
     *      @Column(name="public_pem", type="text", length=65535)
     */
    private $publicPem;

    /**
     *
     * @var string $returnName 退款类名
     *      @Column(name="return_name", type="string", length=50)
     */
    private $returnName;

    /**
     *
     * @var string $returnUrl 同步通知地址
     *      @Column(name="return_url", type="string", length=100)
     */
    private $returnUrl;

    /**
     *
     * @var int $specialStatus 特殊支付【0 商品支付，1套餐支付，2积分支付，3开店支付，4余额充值 】
     *      @Column(name="special_status", type="tinyint", default=0)
     */
    private $specialStatus;

    /**
     *
     * @var int $type 设备类型 0pc 1 wap 2 app 3 微商城
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
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
     * 受理人编号或收款方支付宝账号【一般情况下与合作这身份id一样】
     * 
     * @param string $value            
     * @return $this
     */
    public function setMchid(string $value): self
    {
        $this->mchid = $value;
        
        return $this;
    }

    /**
     * 异步通知url
     * 
     * @param string $value            
     * @return $this
     */
    public function setNotifyUrl(string $value): self
    {
        $this->notifyUrl = $value;
        
        return $this;
    }

    /**
     * 微信openID
     * 
     * @param string $value            
     * @return $this
     */
    public function setOpenId(string $value): self
    {
        $this->openId = $value;
        
        return $this;
    }

    /**
     * 支付账号或APP_ID
     * 
     * @param string $value            
     * @return $this
     */
    public function setPayAccount(string $value): self
    {
        $this->payAccount = $value;
        
        return $this;
    }

    /**
     * 支付秘钥
     * 
     * @param string $value            
     * @return $this
     */
    public function setPayKey(string $value): self
    {
        $this->payKey = $value;
        
        return $this;
    }

    /**
     * 支付类名【不可更改】
     * 
     * @param string $value            
     * @return $this
     */
    public function setPayName(string $value): self
    {
        $this->payName = $value;
        
        return $this;
    }

    /**
     * 支付类型【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPayTypeId(int $value): self
    {
        $this->payTypeId = $value;
        
        return $this;
    }

    /**
     * 私钥
     * 
     * @param string $value            
     * @return $this
     */
    public function setPrivatePem(string $value): self
    {
        $this->privatePem = $value;
        
        return $this;
    }

    /**
     * 公钥
     * 
     * @param string $value            
     * @return $this
     */
    public function setPublicPem(string $value): self
    {
        $this->publicPem = $value;
        
        return $this;
    }

    /**
     * 退款类名
     * 
     * @param string $value            
     * @return $this
     */
    public function setReturnName(string $value): self
    {
        $this->returnName = $value;
        
        return $this;
    }

    /**
     * 同步通知地址
     * 
     * @param string $value            
     * @return $this
     */
    public function setReturnUrl(string $value): self
    {
        $this->returnUrl = $value;
        
        return $this;
    }

    /**
     * 特殊支付【0 商品支付，1套餐支付，2积分支付，3开店支付，4余额充值 】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSpecialStatus(int $value): self
    {
        $this->specialStatus = $value;
        
        return $this;
    }

    /**
     * 设备类型 0pc 1 wap 2 app 3 微商城
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
     * 编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 受理人编号或收款方支付宝账号【一般情况下与合作这身份id一样】
     * 
     * @return string
     */
    public function getMchid()
    {
        return $this->mchid;
    }

    /**
     * 异步通知url
     * 
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    /**
     * 微信openID
     * 
     * @return string
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * 支付账号或APP_ID
     * 
     * @return string
     */
    public function getPayAccount()
    {
        return $this->payAccount;
    }

    /**
     * 支付秘钥
     * 
     * @return string
     */
    public function getPayKey()
    {
        return $this->payKey;
    }

    /**
     * 支付类名【不可更改】
     * 
     * @return string
     */
    public function getPayName()
    {
        return $this->payName;
    }

    /**
     * 支付类型【编号】
     * 
     * @return int
     */
    public function getPayTypeId()
    {
        return $this->payTypeId;
    }

    /**
     * 私钥
     * 
     * @return string
     */
    public function getPrivatePem()
    {
        return $this->privatePem;
    }

    /**
     * 公钥
     * 
     * @return string
     */
    public function getPublicPem()
    {
        return $this->publicPem;
    }

    /**
     * 退款类名
     * 
     * @return string
     */
    public function getReturnName()
    {
        return $this->returnName;
    }

    /**
     * 同步通知地址
     * 
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * 特殊支付【0 商品支付，1套餐支付，2积分支付，3开店支付，4余额充值 】
     * 
     * @return int
     */
    public function getSpecialStatus()
    {
        return $this->specialStatus;
    }

    /**
     * 设备类型 0pc 1 wap 2 app 3 微商城
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
