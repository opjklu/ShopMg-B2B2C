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
 * 店铺退发货地址
 *
 * @Entity()
 * @Table(name="mg_store_deal_address")
 * 
 * @uses DbStoreDealAddress
 */
class DbStoreDealAddress extends Model
{

    /**
     *
     * @var string $address 详细地址
     *      @Column(name="address", type="string", length=255, default="")
     */
    private $address;

    /**
     *
     * @var int $cityId 市
     *      @Column(name="city_id", type="integer", default=0)
     */
    private $cityId;

    /**
     *
     * @var int $distId 区
     *      @Column(name="dist_id", type="integer", default=0)
     */
    private $distId;

    /**
     *
     * @var string $email 邮箱
     *      @Column(name="email", type="string", length=255, default="")
     */
    private $email;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isDefault 是否默认 1为默认 0为不默认
     *      @Column(name="is_default", type="tinyint", default=0)
     */
    private $isDefault;

    /**
     *
     * @var string $name 联系人
     *      @Column(name="name", type="string", length=255, default="")
     */
    private $name;

    /**
     *
     * @var string $phone 手机号码
     *      @Column(name="phone", type="string", length=255, default="")
     */
    private $phone;

    /**
     *
     * @var int $provId 省份
     *      @Column(name="prov_id", type="integer", default=0)
     */
    private $provId;

    /**
     *
     * @var int $storeId 店铺编号
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     * 详细地址
     * 
     * @param string $value            
     * @return $this
     */
    public function setAddress(string $value): self
    {
        $this->address = $value;
        
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
     * 邮箱
     * 
     * @param string $value            
     * @return $this
     */
    public function setEmail(string $value): self
    {
        $this->email = $value;
        
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
     * 是否默认 1为默认 0为不默认
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsDefault(int $value): self
    {
        $this->isDefault = $value;
        
        return $this;
    }

    /**
     * 联系人
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
     * 手机号码
     * 
     * @param string $value            
     * @return $this
     */
    public function setPhone(string $value): self
    {
        $this->phone = $value;
        
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
     * 店铺编号
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
     * 详细地址
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
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
     * 区
     * 
     * @return int
     */
    public function getDistId()
    {
        return $this->distId;
    }

    /**
     * 邮箱
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * 是否默认 1为默认 0为不默认
     * 
     * @return int
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * 联系人
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 手机号码
     * 
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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
     * 店铺编号
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
