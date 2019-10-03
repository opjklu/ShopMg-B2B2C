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
 * 购物车
 *
 * @Entity()
 * @Table(name="mg_goods_cart")
 * 
 * @uses DbGoodsCart
 */
class DbGoodsCart extends Model
{

    /**
     *
     * @var int $attributeId 商品属性编号
     *      @Column(name="attribute_id", type="integer", default=0)
     */
    private $attributeId;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     */
    private $createTime;

    /**
     *
     * @var int $goodsId 商品【id】
     *      @Column(name="goods_id", type="integer", default=0)
     */
    private $goodsId;

    /**
     *
     * @var int $goodsNum 商品数量
     *      @Column(name="goods_num", type="tinyint", default=0)
     */
    private $goodsNum;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $integralRebate 返利积分
     *      @Column(name="integral_rebate", type="integer")
     */
    private $integralRebate;

    /**
     *
     * @var float $priceNew 套餐价
     *      @Column(name="price_new", type="decimal", default=0)
     */
    private $priceNew;

    /**
     *
     * @var int $storeId 店铺编号
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户ID
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     *
     * @var int $wareId 发货仓库
     *      @Column(name="ware_id", type="tinyint", default=0)
     */
    private $wareId;

    /**
     * 商品属性编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setAttributeId(int $value): self
    {
        $this->attributeId = $value;
        
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
     * 商品【id】
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsId(int $value): self
    {
        $this->goodsId = $value;
        
        return $this;
    }

    /**
     * 商品数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsNum(int $value): self
    {
        $this->goodsNum = $value;
        
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
     * 返利积分
     * 
     * @param int $value            
     * @return $this
     */
    public function setIntegralRebate(int $value): self
    {
        $this->integralRebate = $value;
        
        return $this;
    }

    /**
     * 套餐价
     * 
     * @param float $value            
     * @return $this
     */
    public function setPriceNew(float $value): self
    {
        $this->priceNew = $value;
        
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
     * 用户ID
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
     * 发货仓库
     * 
     * @param int $value            
     * @return $this
     */
    public function setWareId(int $value): self
    {
        $this->wareId = $value;
        
        return $this;
    }

    /**
     * 商品属性编号
     * 
     * @return int
     */
    public function getAttributeId()
    {
        return $this->attributeId;
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
     * 商品【id】
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 商品数量
     * 
     * @return int
     */
    public function getGoodsNum()
    {
        return $this->goodsNum;
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
     * 返利积分
     * 
     * @return int
     */
    public function getIntegralRebate()
    {
        return $this->integralRebate;
    }

    /**
     * 套餐价
     * 
     * @return mixed
     */
    public function getPriceNew()
    {
        return $this->priceNew;
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
     * 更新时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 用户ID
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 发货仓库
     * 
     * @return int
     */
    public function getWareId()
    {
        return $this->wareId;
    }
}
