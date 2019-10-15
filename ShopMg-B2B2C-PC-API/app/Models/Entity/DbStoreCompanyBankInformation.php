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
 * 企业入驻信息（银行账号信息）
 *
 * @Entity()
 * @Table(name="mg_store_company_bank_information")
 * 
 * @uses DbStoreCompanyBankInformation
 */
class DbStoreCompanyBankInformation extends Model
{

    /**
     *
     * @var string $accountName 开户名
     *      @Column(name="account_name", type="string", length=50)
     *      @Required()
     */
    private $accountName;

    /**
     *
     * @var string $alipayAccount 支付宝支付账号
     *      @Column(name="alipay_account", type="string", length=20)
     *      @Required()
     */
    private $alipayAccount;

    /**
     *
     * @var string $bankElectronic 开户银行许可证电子版
     *      @Column(name="bank_electronic", type="string", length=80)
     */
    private $bankElectronic;

    /**
     *
     * @var string $branchBank 开户银行支行名称
     *      @Column(name="branch_bank", type="char", length=25, default="")
     */
    private $branchBank;

    /**
     *
     * @var int $branchNumber 支行联行号
     *      @Column(name="branch_number", type="bigint", default=0)
     */
    private $branchNumber;

    /**
     *
     * @var string $certificateNumber 税务登记证号
     *      @Column(name="certificate_number", type="char", length=20, default="0")
     */
    private $certificateNumber;

    /**
     *
     * @var string $companyAccount 公司银行账号
     *      @Column(name="company_account", type="string", length=50, default="")
     */
    private $companyAccount;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $identificationNumber 纳税人识别号
     *      @Column(name="identification_number", type="bigint", default=0)
     */
    private $identificationNumber;

    /**
     *
     * @var int $isSettle 是否以开户行作为结算账号 0-否 1-是
     *      @Column(name="is_settle", type="tinyint", default=1)
     */
    private $isSettle;

    /**
     *
     * @var string $registrationElectronic 税务登记证号电子版
     *      @Column(name="registration_electronic", type="string", length=80, default="")
     */
    private $registrationElectronic;

    /**
     *
     * @var string $settleAccount 结算公司银行账号
     *      @Column(name="settle_account", type="string", length=50, default="")
     */
    private $settleAccount;

    /**
     *
     * @var string $settleBank 结算开户银行支行名称
     *      @Column(name="settle_bank", type="char", length=25, default="")
     */
    private $settleBank;

    /**
     *
     * @var string $settleName 结算账户开户名
     *      @Column(name="settle_name", type="string", length=50, default="")
     */
    private $settleName;

    /**
     *
     * @var int $settleNumber 结算支行联行号
     *      @Column(name="settle_number", type="bigint", default=0)
     */
    private $settleNumber;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var string $wxAccount 微信支付账号
     *      @Column(name="wx_account", type="string", length=20)
     *      @Required()
     */
    private $wxAccount;

    /**
     * 开户名
     * 
     * @param string $value            
     * @return $this
     */
    public function setAccountName(string $value): self
    {
        $this->accountName = $value;
        
        return $this;
    }

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
     * 开户银行许可证电子版
     * 
     * @param string $value            
     * @return $this
     */
    public function setBankElectronic(string $value): self
    {
        $this->bankElectronic = $value;
        
        return $this;
    }

    /**
     * 开户银行支行名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setBranchBank(string $value): self
    {
        $this->branchBank = $value;
        
        return $this;
    }

    /**
     * 支行联行号
     * 
     * @param int $value            
     * @return $this
     */
    public function setBranchNumber(int $value): self
    {
        $this->branchNumber = $value;
        
        return $this;
    }

    /**
     * 税务登记证号
     * 
     * @param string $value            
     * @return $this
     */
    public function setCertificateNumber(string $value): self
    {
        $this->certificateNumber = $value;
        
        return $this;
    }

    /**
     * 公司银行账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setCompanyAccount(string $value): self
    {
        $this->companyAccount = $value;
        
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
     * 纳税人识别号
     * 
     * @param int $value            
     * @return $this
     */
    public function setIdentificationNumber(int $value): self
    {
        $this->identificationNumber = $value;
        
        return $this;
    }

    /**
     * 是否以开户行作为结算账号 0-否 1-是
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsSettle(int $value): self
    {
        $this->isSettle = $value;
        
        return $this;
    }

    /**
     * 税务登记证号电子版
     * 
     * @param string $value            
     * @return $this
     */
    public function setRegistrationElectronic(string $value): self
    {
        $this->registrationElectronic = $value;
        
        return $this;
    }

    /**
     * 结算公司银行账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setSettleAccount(string $value): self
    {
        $this->settleAccount = $value;
        
        return $this;
    }

    /**
     * 结算开户银行支行名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setSettleBank(string $value): self
    {
        $this->settleBank = $value;
        
        return $this;
    }

    /**
     * 结算账户开户名
     * 
     * @param string $value            
     * @return $this
     */
    public function setSettleName(string $value): self
    {
        $this->settleName = $value;
        
        return $this;
    }

    /**
     * 结算支行联行号
     * 
     * @param int $value            
     * @return $this
     */
    public function setSettleNumber(int $value): self
    {
        $this->settleNumber = $value;
        
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
     * 开户名
     * 
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
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
     * 开户银行许可证电子版
     * 
     * @return string
     */
    public function getBankElectronic()
    {
        return $this->bankElectronic;
    }

    /**
     * 开户银行支行名称
     * 
     * @return string
     */
    public function getBranchBank()
    {
        return $this->branchBank;
    }

    /**
     * 支行联行号
     * 
     * @return int
     */
    public function getBranchNumber()
    {
        return $this->branchNumber;
    }

    /**
     * 税务登记证号
     * 
     * @return string
     */
    public function getCertificateNumber()
    {
        return $this->certificateNumber;
    }

    /**
     * 公司银行账号
     * 
     * @return string
     */
    public function getCompanyAccount()
    {
        return $this->companyAccount;
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
     * 纳税人识别号
     * 
     * @return int
     */
    public function getIdentificationNumber()
    {
        return $this->identificationNumber;
    }

    /**
     * 是否以开户行作为结算账号 0-否 1-是
     * 
     * @return mixed
     */
    public function getIsSettle()
    {
        return $this->isSettle;
    }

    /**
     * 税务登记证号电子版
     * 
     * @return string
     */
    public function getRegistrationElectronic()
    {
        return $this->registrationElectronic;
    }

    /**
     * 结算公司银行账号
     * 
     * @return string
     */
    public function getSettleAccount()
    {
        return $this->settleAccount;
    }

    /**
     * 结算开户银行支行名称
     * 
     * @return string
     */
    public function getSettleBank()
    {
        return $this->settleBank;
    }

    /**
     * 结算账户开户名
     * 
     * @return string
     */
    public function getSettleName()
    {
        return $this->settleName;
    }

    /**
     * 结算支行联行号
     * 
     * @return int
     */
    public function getSettleNumber()
    {
        return $this->settleNumber;
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
     * 微信支付账号
     * 
     * @return string
     */
    public function getWxAccount()
    {
        return $this->wxAccount;
    }
}
