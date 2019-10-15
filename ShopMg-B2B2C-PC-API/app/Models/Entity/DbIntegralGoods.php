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
 * 积分商品表
 *
 * @Entity()
 * @Table(name="mg_integral_goods")
 * 
 * @uses DbIntegralGoods
 */
class DbIntegralGoods extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $delayed 积分最少被领取时间【最少0,最大999】
     *      @Column(name="delayed", type="smallint", default=0)
     */
    private $delayed;

    /**
     *
     * @var int $goodsId 商品ID
     *      @Column(name="goods_id", type="integer")
     *      @Required()
     */
    private $goodsId;

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $integral 需要的积分
     *      @Column(name="integral", type="integer", default=0)
     */
    private $integral;

    /**
     *
     * @var int $isShow 是否显示【1显示 0不显示】
     *      @Column(name="is_show", type="tinyint", default=1)
     */
    private $isShow;

    /**
     *
     * @var float $money 金额【换取商品需要另外添加的钱】
     *      @Column(name="money", type="decimal", default=0)
     */
    private $money;

    /**
     *
     * @var int $status 是可兑换
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺【id】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 修改时间
     *      @Column(name="update_time", type="bigint", default=0)
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
     * 积分最少被领取时间【最少0,最大999】
     * 
     * @param int $value            
     * @return $this
     */
    public function setDelayed(int $value): self
    {
        $this->delayed = $value;
        
        return $this;
    }

    /**
     * 商品ID
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
     * 需要的积分
     * 
     * @param int $value            
     * @return $this
     */
    public function setIntegral(int $value): self
    {
        $this->integral = $value;
        
        return $this;
    }

    /**
     * 是否显示【1显示 0不显示】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsShow(int $value): self
    {
        $this->isShow = $value;
        
        return $this;
    }

    /**
     * 金额【换取商品需要另外添加的钱】
     * 
     * @param float $value            
     * @return $this
     */
    public function setMoney(float $value): self
    {
        $this->money = $value;
        
        return $this;
    }

    /**
     * 是可兑换
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
     * 店铺【id】
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
     * 积分最少被领取时间【最少0,最大999】
     * 
     * @return int
     */
    public function getDelayed()
    {
        return $this->delayed;
    }

    /**
     * 商品ID
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 需要的积分
     * 
     * @return int
     */
    public function getIntegral()
    {
        return $this->integral;
    }

    /**
     * 是否显示【1显示 0不显示】
     * 
     * @return mixed
     */
    public function getIsShow()
    {
        return $this->isShow;
    }

    /**
     * 金额【换取商品需要另外添加的钱】
     * 
     * @return mixed
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * 是可兑换
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺【id】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
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
