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
 * 套餐购物车
 *
 * @Entity()
 * @Table(name="mg_goods_package_cart")
 * 
 * @uses DbGoodsPackageCart
 */
class DbGoodsPackageCart extends Model
{

    /**
     *
     * @var int $createTime 创建日期
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id 套餐购物车【编号】
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $packageId 套餐【编号】
     *      @Column(name="package_id", type="integer", default=0)
     */
    private $packageId;

    /**
     *
     * @var int $packageNum 套餐数量
     *      @Column(name="package_num", type="integer", default=1)
     */
    private $packageNum;

    /**
     *
     * @var int $storeId 商户编号
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 修改日期
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 创建日期
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
     * 套餐购物车【编号】
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
     * 套餐【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPackageId(int $value): self
    {
        $this->packageId = $value;
        
        return $this;
    }

    /**
     * 套餐数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setPackageNum(int $value): self
    {
        $this->packageNum = $value;
        
        return $this;
    }

    /**
     * 商户编号
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
     * 修改日期
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
     * 用户
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
     * 创建日期
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 套餐购物车【编号】
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 套餐【编号】
     * 
     * @return int
     */
    public function getPackageId()
    {
        return $this->packageId;
    }

    /**
     * 套餐数量
     * 
     * @return mixed
     */
    public function getPackageNum()
    {
        return $this->packageNum;
    }

    /**
     * 商户编号
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 修改日期
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 用户
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
