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
 * 用户收货地址表
 *
 * @Entity()
 * @Table(name="mg_user_address")
 * 
 * @uses DbUserAddress
 */
class DbUserAddress extends Model
{

    /**
     *
     * @var string $address 地址说
     *      @Column(name="address", type="string", length=100)
     *      @Required()
     */
    private $address;

    /**
     *
     * @var string $alias 地址别名
     *      @Column(name="alias", type="string", length=50)
     */
    private $alias;

    /**
     *
     * @var int $city 城市编号
     *      @Column(name="city", type="integer", default=0)
     */
    private $city;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $dist 区域编号
     *      @Column(name="dist", type="integer", default=0)
     */
    private $dist;

    /**
     *
     * @var string $email 电子邮件
     *      @Column(name="email", type="string", length=50)
     */
    private $email;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $mobile 手机号
     *      @Column(name="mobile", type="bigint")
     *      @Required()
     */
    private $mobile;

    /**
     *
     * @var int $prov 省
     *      @Column(name="prov", type="integer", default=0)
     */
    private $prov;

    /**
     *
     * @var string $realname 名字
     *      @Column(name="realname", type="string", length=20)
     */
    private $realname;

    /**
     *
     * @var int $status 是否默认地址 默认 1 不默认 0
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var string $telphone 座机
     *      @Column(name="telphone", type="string", length=11, default="0")
     */
    private $telphone;

    /**
     *
     * @var int $type 地址类型【0 -收货地址，1-公司地址（店铺地址），2-开户行地址，3-结算账号开户行地址，4- 实体店地址
     *      @Column(name="type", type="tinyint", default=0)
     */
    private $type;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer")
     */
    private $updateTime;

    /**
     *
     * @var int $userId user_id
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     *
     * @var int $zipcode 邮编
     *      @Column(name="zipcode", type="integer")
     */
    private $zipcode;

    /**
     * 地址说
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
     * 地址别名
     * 
     * @param string $value            
     * @return $this
     */
    public function setAlias(string $value): self
    {
        $this->alias = $value;
        
        return $this;
    }

    /**
     * 城市编号
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
     * 区域编号
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
     * 电子邮件
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
     * 手机号
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
     * 名字
     * 
     * @param string $value            
     * @return $this
     */
    public function setRealname(string $value): self
    {
        $this->realname = $value;
        
        return $this;
    }

    /**
     * 是否默认地址 默认 1 不默认 0
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
     * 座机
     * 
     * @param string $value            
     * @return $this
     */
    public function setTelphone(string $value): self
    {
        $this->telphone = $value;
        
        return $this;
    }

    /**
     * 地址类型【0 -收货地址，1-公司地址（店铺地址），2-开户行地址，3-结算账号开户行地址，4- 实体店地址
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
     * user_id
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
     * 邮编
     * 
     * @param int $value            
     * @return $this
     */
    public function setZipcode(int $value): self
    {
        $this->zipcode = $value;
        
        return $this;
    }

    /**
     * 地址说
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * 地址别名
     * 
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * 城市编号
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
     * 区域编号
     * 
     * @return int
     */
    public function getDist()
    {
        return $this->dist;
    }

    /**
     * 电子邮件
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * 手机号
     * 
     * @return int
     */
    public function getMobile()
    {
        return $this->mobile;
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
     * 名字
     * 
     * @return string
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * 是否默认地址 默认 1 不默认 0
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 座机
     * 
     * @return string
     */
    public function getTelphone()
    {
        return $this->telphone;
    }

    /**
     * 地址类型【0 -收货地址，1-公司地址（店铺地址），2-开户行地址，3-结算账号开户行地址，4- 实体店地址
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

    /**
     * user_id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 邮编
     * 
     * @return int
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }
}
