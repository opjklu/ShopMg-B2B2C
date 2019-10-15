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
 * 增资发票表
 *
 * @Entity()
 * @Table(name="mg_capita_invoice")
 * 
 * @uses DbCapitaInvoice
 */
class DbCapitaInvoice extends Model
{

    /**
     *
     * @var int $bankAccount 开户行账号
     *      @Column(name="bank_account", type="bigint")
     *      @Required()
     */
    private $bankAccount;

    /**
     *
     * @var int $cityId 市
     *      @Column(name="city_id", type="integer")
     *      @Required()
     */
    private $cityId;

    /**
     *
     * @var string $companyName 公司名称
     *      @Column(name="company_name", type="string", length=50)
     *      @Required()
     */
    private $companyName;

    /**
     *
     * @var int $createTime 添加时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $distId 区
     *      @Column(name="dist_id", type="integer")
     *      @Required()
     */
    private $distId;

    /**
     *
     * @var int $ein 税号
     *      @Column(name="ein", type="integer")
     *      @Required()
     */
    private $ein;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $openingBank 开户行
     *      @Column(name="opening_bank", type="string", length=50)
     *      @Required()
     */
    private $openingBank;

    /**
     *
     * @var int $provId 省份
     *      @Column(name="prov_id", type="integer")
     *      @Required()
     */
    private $provId;

    /**
     *
     * @var string $registerAddress 注册地址
     *      @Column(name="register_address", type="string", length=100)
     *      @Required()
     */
    private $registerAddress;

    /**
     *
     * @var int $registerTel 注册电话
     *      @Column(name="register_tel", type="bigint")
     *      @Required()
     */
    private $registerTel;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户[编号]
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 开户行账号
     * 
     * @param int $value            
     * @return $this
     */
    public function setBankAccount(int $value): self
    {
        $this->bankAccount = $value;
        
        return $this;
    }

    /**
     * 市
     * 
     * @param int $value            
     * @return $this
     */
    public function setCityId(int $value): self
    {
        $this->cityId = $value;
        
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
     * 区
     * 
     * @param int $value            
     * @return $this
     */
    public function setDistId(int $value): self
    {
        $this->distId = $value;
        
        return $this;
    }

    /**
     * 税号
     * 
     * @param int $value            
     * @return $this
     */
    public function setEin(int $value): self
    {
        $this->ein = $value;
        
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
     * 开户行
     * 
     * @param string $value            
     * @return $this
     */
    public function setOpeningBank(string $value): self
    {
        $this->openingBank = $value;
        
        return $this;
    }

    /**
     * 省份
     * 
     * @param int $value            
     * @return $this
     */
    public function setProvId(int $value): self
    {
        $this->provId = $value;
        
        return $this;
    }

    /**
     * 注册地址
     * 
     * @param string $value            
     * @return $this
     */
    public function setRegisterAddress(string $value): self
    {
        $this->registerAddress = $value;
        
        return $this;
    }

    /**
     * 注册电话
     * 
     * @param int $value            
     * @return $this
     */
    public function setRegisterTel(int $value): self
    {
        $this->registerTel = $value;
        
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
     * 用户[编号]
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
     * 开户行账号
     * 
     * @return int
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * 市
     * 
     * @return int
     */
    public function getCityId()
    {
        return $this->cityId;
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
     * 添加时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 区
     * 
     * @return int
     */
    public function getDistId()
    {
        return $this->distId;
    }

    /**
     * 税号
     * 
     * @return int
     */
    public function getEin()
    {
        return $this->ein;
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
     * 开户行
     * 
     * @return string
     */
    public function getOpeningBank()
    {
        return $this->openingBank;
    }

    /**
     * 省份
     * 
     * @return int
     */
    public function getProvId()
    {
        return $this->provId;
    }

    /**
     * 注册地址
     * 
     * @return string
     */
    public function getRegisterAddress()
    {
        return $this->registerAddress;
    }

    /**
     * 注册电话
     * 
     * @return int
     */
    public function getRegisterTel()
    {
        return $this->registerTel;
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
     * 用户[编号]
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
