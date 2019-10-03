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
 * 店铺经营信息
 *
 * @Entity()
 * @Table(name="mg_store_information")
 * 
 * @uses DbStoreInformation
 */
class DbStoreInformation extends Model
{

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $levelId 店铺等级
     *      @Column(name="level_id", type="integer")
     *      @Required()
     */
    private $levelId;

    /**
     *
     * @var string $payingCertif 付款凭证说明
     *      @Column(name="paying_certif", type="string", length=50)
     */
    private $payingCertif;

    /**
     *
     * @var string $payingCertificate 付款凭证
     *      @Column(name="paying_certificate", type="string", length=50)
     */
    private $payingCertificate;

    /**
     *
     * @var float $scBail 店铺分类保证金
     *      @Column(name="sc_bail", type="decimal", default=0)
     */
    private $scBail;

    /**
     *
     * @var string $shopAccount 商家账号
     *      @Column(name="shop_account", type="string", length=50)
     *      @Required()
     */
    private $shopAccount;

    /**
     *
     * @var int $shopClass 店铺分类
     *      @Column(name="shop_class", type="integer")
     *      @Required()
     */
    private $shopClass;

    /**
     *
     * @var int $shopLong 开店时长
     *      @Column(name="shop_long", type="integer")
     *      @Required()
     */
    private $shopLong;

    /**
     *
     * @var string $shopName 店铺名称
     *      @Column(name="shop_name", type="string", length=50)
     *      @Required()
     */
    private $shopName;

    /**
     *
     * @var int $status 入驻类型 0个人入住 1 企业入驻
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 公司入驻表编号
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

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
     * 店铺等级
     * 
     * @param int $value            
     * @return $this
     */
    public function setLevelId(int $value): self
    {
        $this->levelId = $value;
        
        return $this;
    }

    /**
     * 付款凭证说明
     * 
     * @param string $value            
     * @return $this
     */
    public function setPayingCertif(string $value): self
    {
        $this->payingCertif = $value;
        
        return $this;
    }

    /**
     * 付款凭证
     * 
     * @param string $value            
     * @return $this
     */
    public function setPayingCertificate(string $value): self
    {
        $this->payingCertificate = $value;
        
        return $this;
    }

    /**
     * 店铺分类保证金
     * 
     * @param float $value            
     * @return $this
     */
    public function setScBail(float $value): self
    {
        $this->scBail = $value;
        
        return $this;
    }

    /**
     * 商家账号
     * 
     * @param string $value            
     * @return $this
     */
    public function setShopAccount(string $value): self
    {
        $this->shopAccount = $value;
        
        return $this;
    }

    /**
     * 店铺分类
     * 
     * @param int $value            
     * @return $this
     */
    public function setShopClass(int $value): self
    {
        $this->shopClass = $value;
        
        return $this;
    }

    /**
     * 开店时长
     * 
     * @param int $value            
     * @return $this
     */
    public function setShopLong(int $value): self
    {
        $this->shopLong = $value;
        
        return $this;
    }

    /**
     * 店铺名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setShopName(string $value): self
    {
        $this->shopName = $value;
        
        return $this;
    }

    /**
     * 入驻类型 0个人入住 1 企业入驻
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
     * 公司入驻表编号
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
     * 编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 店铺等级
     * 
     * @return int
     */
    public function getLevelId()
    {
        return $this->levelId;
    }

    /**
     * 付款凭证说明
     * 
     * @return string
     */
    public function getPayingCertif()
    {
        return $this->payingCertif;
    }

    /**
     * 付款凭证
     * 
     * @return string
     */
    public function getPayingCertificate()
    {
        return $this->payingCertificate;
    }

    /**
     * 店铺分类保证金
     * 
     * @return mixed
     */
    public function getScBail()
    {
        return $this->scBail;
    }

    /**
     * 商家账号
     * 
     * @return string
     */
    public function getShopAccount()
    {
        return $this->shopAccount;
    }

    /**
     * 店铺分类
     * 
     * @return int
     */
    public function getShopClass()
    {
        return $this->shopClass;
    }

    /**
     * 开店时长
     * 
     * @return int
     */
    public function getShopLong()
    {
        return $this->shopLong;
    }

    /**
     * 店铺名称
     * 
     * @return string
     */
    public function getShopName()
    {
        return $this->shopName;
    }

    /**
     * 入驻类型 0个人入住 1 企业入驻
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 公司入驻表编号
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
