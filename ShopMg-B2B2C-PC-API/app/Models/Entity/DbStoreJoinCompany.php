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
 * 企业入驻信息（公司及联系人信息）
 *
 * @Entity()
 * @Table(name="mg_store_join_company")
 * 
 * @uses DbStoreJoinCompany
 */
class DbStoreJoinCompany extends Model
{

    /**
     *
     * @var string $companyMobile 公司电话
     *      @Column(name="company_mobile", type="string", length=50)
     */
    private $companyMobile;

    /**
     *
     * @var string $companyName 公司名称
     *      @Column(name="company_name", type="string", length=50, default="")
     */
    private $companyName;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var string $electronicVersion 营业执照电子版
     *      @Column(name="electronic_version", type="string", length=100)
     *      @Required()
     */
    private $electronicVersion;

    /**
     *
     * @var int $id 主键编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $licenseNumber 营业执照号
     *      @Column(name="license_number", type="string", length=20, default="")
     */
    private $licenseNumber;

    /**
     *
     * @var int $mobile 联系人手机
     *      @Column(name="mobile", type="bigint")
     */
    private $mobile;

    /**
     *
     * @var string $name 联系人姓名
     *      @Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     *
     * @var int $numberEmployees 员工数
     *      @Column(name="number_employees", type="integer", default=0)
     */
    private $numberEmployees;

    /**
     *
     * @var string $organizationCode 组织机构代码
     *      @Column(name="organization_code", type="string", length=50)
     *      @Required()
     */
    private $organizationCode;

    /**
     *
     * @var string $organizationElectronic 组织机构代码证电子版
     *      @Column(name="organization_electronic", type="string", length=100)
     *      @Required()
     */
    private $organizationElectronic;

    /**
     *
     * @var float $registeredCapital 注册资金数
     *      @Column(name="registered_capital", type="decimal", default=0)
     */
    private $registeredCapital;

    /**
     *
     * @var string $remark 备注
     *      @Column(name="remark", type="string", length=100)
     */
    private $remark;

    /**
     *
     * @var string $scopeOfOperation 法定经营范围
     *      @Column(name="scope_of_operation", type="text", length=65535)
     */
    private $scopeOfOperation;

    /**
     *
     * @var int $status 申请状态 【0-已提交申请 1-缴费完成 2-审核成功 3-审核失败 4-缴费审核失败 5-审核通过开店】
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var string $storeName 店铺名称
     *      @Column(name="store_name", type="string", length=50, default="")
     */
    private $storeName;

    /**
     *
     * @var string $taxpayerCertificate 一般纳税人证明
     *      @Column(name="taxpayer_certificate", type="string", length=100)
     *      @Required()
     */
    private $taxpayerCertificate;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $userId 申请人
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     *
     * @var int $validityEnd 营业执照结束日期
     *      @Column(name="validity_end", type="bigint", default=0)
     */
    private $validityEnd;

    /**
     *
     * @var int $validityStart 营业执照开始日期
     *      @Column(name="validity_start", type="bigint", default=0)
     */
    private $validityStart;

    /**
     * 公司电话
     * 
     * @param string $value            
     * @return $this
     */
    public function setCompanyMobile(string $value): self
    {
        $this->companyMobile = $value;
        
        return $this;
    }

    /**
     * 公司名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setCompanyName(string $value): self
    {
        $this->companyName = $value;
        
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
     * 营业执照电子版
     * 
     * @param string $value            
     * @return $this
     */
    public function setElectronicVersion(string $value): self
    {
        $this->electronicVersion = $value;
        
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
     * 营业执照号
     * 
     * @param string $value            
     * @return $this
     */
    public function setLicenseNumber(string $value): self
    {
        $this->licenseNumber = $value;
        
        return $this;
    }

    /**
     * 联系人手机
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
     * 联系人姓名
     * 
     * @param string $value            
     * @return $this
     */
    public function setName(string $value): self
    {
        $this->name = $value;
        
        return $this;
    }

    /**
     * 员工数
     * 
     * @param int $value            
     * @return $this
     */
    public function setNumberEmployees(int $value): self
    {
        $this->numberEmployees = $value;
        
        return $this;
    }

    /**
     * 组织机构代码
     * 
     * @param string $value            
     * @return $this
     */
    public function setOrganizationCode(string $value): self
    {
        $this->organizationCode = $value;
        
        return $this;
    }

    /**
     * 组织机构代码证电子版
     * 
     * @param string $value            
     * @return $this
     */
    public function setOrganizationElectronic(string $value): self
    {
        $this->organizationElectronic = $value;
        
        return $this;
    }

    /**
     * 注册资金数
     * 
     * @param float $value            
     * @return $this
     */
    public function setRegisteredCapital(float $value): self
    {
        $this->registeredCapital = $value;
        
        return $this;
    }

    /**
     * 备注
     * 
     * @param string $value            
     * @return $this
     */
    public function setRemark(string $value): self
    {
        $this->remark = $value;
        
        return $this;
    }

    /**
     * 法定经营范围
     * 
     * @param string $value            
     * @return $this
     */
    public function setScopeOfOperation(string $value): self
    {
        $this->scopeOfOperation = $value;
        
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
     * 一般纳税人证明
     * 
     * @param string $value            
     * @return $this
     */
    public function setTaxpayerCertificate(string $value): self
    {
        $this->taxpayerCertificate = $value;
        
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
     * 申请人
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
     * 营业执照结束日期
     * 
     * @param int $value            
     * @return $this
     */
    public function setValidityEnd(int $value): self
    {
        $this->validityEnd = $value;
        
        return $this;
    }

    /**
     * 营业执照开始日期
     * 
     * @param int $value            
     * @return $this
     */
    public function setValidityStart(int $value): self
    {
        $this->validityStart = $value;
        
        return $this;
    }

    /**
     * 公司电话
     * 
     * @return string
     */
    public function getCompanyMobile()
    {
        return $this->companyMobile;
    }

    /**
     * 公司名称
     * 
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
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
     * 营业执照电子版
     * 
     * @return string
     */
    public function getElectronicVersion()
    {
        return $this->electronicVersion;
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
     * 营业执照号
     * 
     * @return string
     */
    public function getLicenseNumber()
    {
        return $this->licenseNumber;
    }

    /**
     * 联系人手机
     * 
     * @return int
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * 联系人姓名
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 员工数
     * 
     * @return int
     */
    public function getNumberEmployees()
    {
        return $this->numberEmployees;
    }

    /**
     * 组织机构代码
     * 
     * @return string
     */
    public function getOrganizationCode()
    {
        return $this->organizationCode;
    }

    /**
     * 组织机构代码证电子版
     * 
     * @return string
     */
    public function getOrganizationElectronic()
    {
        return $this->organizationElectronic;
    }

    /**
     * 注册资金数
     * 
     * @return mixed
     */
    public function getRegisteredCapital()
    {
        return $this->registeredCapital;
    }

    /**
     * 备注
     * 
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * 法定经营范围
     * 
     * @return string
     */
    public function getScopeOfOperation()
    {
        return $this->scopeOfOperation;
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
     * 一般纳税人证明
     * 
     * @return string
     */
    public function getTaxpayerCertificate()
    {
        return $this->taxpayerCertificate;
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
     * 申请人
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 营业执照结束日期
     * 
     * @return int
     */
    public function getValidityEnd()
    {
        return $this->validityEnd;
    }

    /**
     * 营业执照开始日期
     * 
     * @return int
     */
    public function getValidityStart()
    {
        return $this->validityStart;
    }
}
