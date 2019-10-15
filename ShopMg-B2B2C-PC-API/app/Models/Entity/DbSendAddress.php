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
 * 发货地址列表
 *
 * @Entity()
 * @Table(name="mg_send_address")
 * 
 * @uses DbSendAddress
 */
class DbSendAddress extends Model
{

    /**
     *
     * @var string $addressDetail 详细地址
     *      @Column(name="address_detail", type="string", length=150)
     */
    private $addressDetail;

    /**
     *
     * @var int $city 市
     *      @Column(name="city", type="integer", default=0)
     */
    private $city;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $def 是否默认[0不默认1默认]
     *      @Column(name="def", type="tinyint", default=0)
     */
    private $def;

    /**
     *
     * @var int $dist 县
     *      @Column(name="dist", type="integer", default=0)
     */
    private $dist;

    /**
     *
     * @var int $id 运送编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $prov 省
     *      @Column(name="prov", type="integer", default=0)
     */
    private $prov;

    /**
     *
     * @var int $status 是否启用[0启用1不启用]
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var string $stockName 仓库名称
     *      @Column(name="stock_name", type="string", length=50, default="")
     */
    private $stockName;

    /**
     *
     * @var int $storeId 店铺id
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     * 详细地址
     * 
     * @param string $value            
     * @return $this
     */
    public function setAddressDetail(string $value): self
    {
        $this->addressDetail = $value;
        
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
     * 是否默认[0不默认1默认]
     * 
     * @param int $value            
     * @return $this
     */
    public function setDef(int $value): self
    {
        $this->def = $value;
        
        return $this;
    }

    /**
     * 县
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
     * 运送编号
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
    public function setProv(int $value): self
    {
        $this->prov = $value;
        
        return $this;
    }

    /**
     * 是否启用[0启用1不启用]
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
     * 仓库名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setStockName(string $value): self
    {
        $this->stockName = $value;
        
        return $this;
    }

    /**
     * 店铺id
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
     * 详细地址
     * 
     * @return string
     */
    public function getAddressDetail()
    {
        return $this->addressDetail;
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 是否默认[0不默认1默认]
     * 
     * @return int
     */
    public function getDef()
    {
        return $this->def;
    }

    /**
     * 县
     * 
     * @return int
     */
    public function getDist()
    {
        return $this->dist;
    }

    /**
     * 运送编号
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
    public function getProv()
    {
        return $this->prov;
    }

    /**
     * 是否启用[0启用1不启用]
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 仓库名称
     * 
     * @return string
     */
    public function getStockName()
    {
        return $this->stockName;
    }

    /**
     * 店铺id
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
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
