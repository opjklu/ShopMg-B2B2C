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
 * 优惠套餐
 *
 * @Entity()
 * @Table(name="mg_goods_package")
 * 
 * @uses DbGoodsPackage
 */
class DbGoodsPackage extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var float $discount 优惠总价
     *      @Column(name="discount", type="decimal")
     */
    private $discount;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $status 审核状态【0拒绝， 1通过，2审核中】
     *      @Column(name="status", type="tinyint", default=2)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺编号
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var string $title 套餐名称
     *      @Column(name="title", type="string", length=50)
     *      @Required()
     */
    private $title;

    /**
     *
     * @var float $total 商品总价
     *      @Column(name="total", type="decimal")
     */
    private $total;

    /**
     *
     * @var int $updateTime 修改时间
     *      @Column(name="update_time", type="integer")
     */
    private $updateTime;

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
     * 优惠总价
     * 
     * @param float $value            
     * @return $this
     */
    public function setDiscount(float $value): self
    {
        $this->discount = $value;
        
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
     * 审核状态【0拒绝， 1通过，2审核中】
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
     * 套餐名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;
        
        return $this;
    }

    /**
     * 商品总价
     * 
     * @param float $value            
     * @return $this
     */
    public function setTotal(float $value): self
    {
        $this->total = $value;
        
        return $this;
    }

    /**
     * 修改时间
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 优惠总价
     * 
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
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
     * 审核状态【0拒绝， 1通过，2审核中】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
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
     * 套餐名称
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 商品总价
     * 
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * 修改时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
