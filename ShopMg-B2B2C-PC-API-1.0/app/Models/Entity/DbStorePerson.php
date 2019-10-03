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
 * 个人入驻
 *
 * @Entity()
 * @Table(name="mg_store_person")
 * 
 * @uses DbStorePerson
 */
class DbStorePerson extends Model
{

    /**
     *
     * @var string $alipayAccount 支付宝支付账号
     *      @Column(name="alipay_account", type="string", length=20)
     *      @Required()
     */
    private $alipayAccount;

    /**
     *
     * @var string $bankAccount 银行账号
     *      @Column(name="bank_account", type="string", length=50, default="")
     */
    private $bankAccount;

    /**
     *
     * @var string $bankName 银行名称
     *      @Column(name="bank_name", type="string", length=50, default="")
     */
    private $bankName;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $id 主键编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $idCard 身份证号码
     *      @Column(name="id_card", type="char", length=18)
     *      @Required()
     */
    private $idCard;

    /**
     *
     * @var string $idcardPositive 身份证正面
     *      @Column(name="idcard_positive", type="string", length=80, default="")
     */
    private $idcardPositive;

    /**
     *
     * @var int $mobile 联系人电话
     *      @Column(name="mobile", type="bigint", default=0)
     */
    private $mobile;

    /**
     *
     * @var string $otherSide 身份证反面
     *      @Column(name="other_side", type="string", length=80, default="")
     */
    private $otherSide;

    /**
     *
     * @var string $personName 姓名
     *      @Column(name="person_name", type="string", length=50)
     *      @Required()
     */
    private $personName;

    /**
     *
     * @var int $status 申请状态 【0-已提交申请 1-缴费完成 2-审核成功 3-审核失败 4-缴费审核失败 5-审核通过开店】
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var string $storeName 店铺名称
     *      @Column(name="store_name", type="string", length=50)
     *      @Required()
     */
    private $storeName;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户编号
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     *
     * @var string $wxAccount 微信支付账号
     *      @Column(name="wx_account", type="string", length=20)
     *      @Required()
     */
    private $wxAccount;

    /**
     * 支付宝支付账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setAlipayAccount(string $value): self
    {
        $this->alipayAccount = $value;
        
        return $this;
    }

    /**
     * 银行账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setBankAccount(string $value): self
    {
        $this->bankAccount = $value;
        
        return $this;
    }

    /**
     * 银行名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setBankName(string $value): self
    {
        $this->bankName = $value;
        
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
     * 主键编号
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
     * 身份证号码
     * 
     * @param string $value            
     * @return $this
     */
    public function setIdCard(string $value): self
    {
        $this->idCard = $value;
        
        return $this;
    }

    /**
     * 身份证正面
     * 
     * @param string $value            
     * @return $this
     */
    public function setIdcardPositive(string $value): self
    {
        $this->idcardPositive = $value;
        
        return $this;
    }

    /**
     * 联系人电话
     * 
     * @param int $value            
     * @return $this
     */
    public function setMobile(int $value): self
    {
        $this->mobile = $value;
        
        return $this;
    }

    /**
     * 身份证反面
     * 
     * @param string $value            
     * @return $this
     */
    public function setOtherSide(string $value): self
    {
        $this->otherSide = $value;
        
        return $this;
    }

    /**
     * 姓名
     * 
     * @param string $value            
     * @return $this
     */
    public function setPersonName(string $value): self
    {
        $this->personName = $value;
        
        return $this;
    }

    /**
     * 申请状态 【0-已提交申请 1-缴费完成 2-审核成功 3-审核失败 4-缴费审核失败 5-审核通过开店】
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
     * 店铺名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setStoreName(string $value): self
    {
        $this->storeName = $value;
        
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
     * 用户编号
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
     * 微信支付账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setWxAccount(string $value): self
    {
        $this->wxAccount = $value;
        
        return $this;
    }

    /**
     * 支付宝支付账号
     * 
     * @return string
     */
    public function getAlipayAccount()
    {
        return $this->alipayAccount;
    }

    /**
     * 银行账号
     * 
     * @return string
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * 银行名称
     * 
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
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
     * 主键编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 身份证号码
     * 
     * @return string
     */
    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * 身份证正面
     * 
     * @return string
     */
    public function getIdcardPositive()
    {
        return $this->idcardPositive;
    }

    /**
     * 联系人电话
     * 
     * @return int
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * 身份证反面
     * 
     * @return string
     */
    public function getOtherSide()
    {
        return $this->otherSide;
    }

    /**
     * 姓名
     * 
     * @return string
     */
    public function getPersonName()
    {
        return $this->personName;
    }

    /**
     * 申请状态 【0-已提交申请 1-缴费完成 2-审核成功 3-审核失败 4-缴费审核失败 5-审核通过开店】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺名称
     * 
     * @return string
     */
    public function getStoreName()
    {
        return $this->storeName;
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
     * 用户编号
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 微信支付账号
     * 
     * @return string
     */
    public function getWxAccount()
    {
        return $this->wxAccount;
    }
}
