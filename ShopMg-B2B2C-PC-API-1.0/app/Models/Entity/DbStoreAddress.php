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
 * 店铺地址表
 *
 * @Entity()
 * @Table(name="mg_store_address")
 * 
 * @uses DbStoreAddress
 */
class DbStoreAddress extends Model
{

    /**
     *
     * @var string $address 详细地址
     *      @Column(name="address", type="string", length=100, default="")
     */
    private $address;

    /**
     *
     * @var int $city 市
     *      @Column(name="city", type="integer", default=0)
     */
    private $city;

    /**
     *
     * @var int $dist 区
     *      @Column(name="dist", type="integer", default=0)
     */
    private $dist;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $provId 省
     *      @Column(name="prov_id", type="integer", default=0)
     */
    private $provId;

    /**
     *
     * @var int $storeId 店铺编号
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $storeZip 邮政编码
     *      @Column(name="store_zip", type="integer", default=0)
     */
    private $storeZip;

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
    public function setCity(int $value): self
    {
        $this->city = $value;
        
        return $this;
    }

    /**
     * 区
     * 
     * @param int $value            
     * @return $this
     */
    public function setDist(int $value): self
    {
        $this->dist = $value;
        
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
     * 省
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
     * 邮政编码
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreZip(int $value): self
    {
        $this->storeZip = $value;
        
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
    public function getCity()
    {
        return $this->city;
    }

    /**
     * 区
     * 
     * @return int
     */
    public function getDist()
    {
        return $this->dist;
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
     * 省
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

    /**
     * 邮政编码
     * 
     * @return int
     */
    public function getStoreZip()
    {
        return $this->storeZip;
    }
}
