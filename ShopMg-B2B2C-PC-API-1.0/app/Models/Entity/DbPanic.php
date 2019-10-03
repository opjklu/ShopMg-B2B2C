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
 * 抢购表
 *
 * @Entity()
 * @Table(name="mg_panic")
 * 
 * @uses DbPanic
 */
class DbPanic extends Model
{

    /**
     *
     * @var int $alreadyNum 已购买
     *      @Column(name="already_num", type="integer", default=0)
     */
    private $alreadyNum;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $endTime 结束时间
     *      @Column(name="end_time", type="bigint", default=0)
     */
    private $endTime;

    /**
     *
     * @var int $goodsId 商品编号
     *      @Column(name="goods_id", type="integer", default=0)
     */
    private $goodsId;

    /**
     *
     * @var int $id 抢购编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $panicNum 参加抢购数量
     *      @Column(name="panic_num", type="integer", default=0)
     */
    private $panicNum;

    /**
     *
     * @var float $panicPrice 抢购价格
     *      @Column(name="panic_price", type="decimal", default=0)
     */
    private $panicPrice;

    /**
     *
     * @var string $panicTitle 抢购标题
     *      @Column(name="panic_title", type="char", length=100, default="")
     */
    private $panicTitle;

    /**
     *
     * @var int $quantityLimit 限购数量
     *      @Column(name="quantity_limit", type="integer", default=0)
     */
    private $quantityLimit;

    /**
     *
     * @var int $startTime 开始时间
     *      @Column(name="start_time", type="bigint", default=0)
     */
    private $startTime;

    /**
     *
     * @var int $status 审核状态【0拒绝，1通过，2审核中】
     *      @Column(name="status", type="tinyint", default=2)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺【编号】
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
     * 已购买
     * 
     * @param int $value            
     * @return $this
     */
    public function setAlreadyNum(int $value): self
    {
        $this->alreadyNum = $value;
        
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
     * 结束时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setEndTime(int $value): self
    {
        $this->endTime = $value;
        
        return $this;
    }

    /**
     * 商品编号
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
     * 抢购编号
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
     * 参加抢购数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setPanicNum(int $value): self
    {
        $this->panicNum = $value;
        
        return $this;
    }

    /**
     * 抢购价格
     * 
     * @param float $value            
     * @return $this
     */
    public function setPanicPrice(float $value): self
    {
        $this->panicPrice = $value;
        
        return $this;
    }

    /**
     * 抢购标题
     * 
     * @param string $value            
     * @return $this
     */
    public function setPanicTitle(string $value): self
    {
        $this->panicTitle = $value;
        
        return $this;
    }

    /**
     * 限购数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setQuantityLimit(int $value): self
    {
        $this->quantityLimit = $value;
        
        return $this;
    }

    /**
     * 开始时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setStartTime(int $value): self
    {
        $this->startTime = $value;
        
        return $this;
    }

    /**
     * 审核状态【0拒绝，1通过，2审核中】
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
     * 店铺【编号】
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
     * 已购买
     * 
     * @return int
     */
    public function getAlreadyNum()
    {
        return $this->alreadyNum;
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
     * 结束时间
     * 
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * 商品编号
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 抢购编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 参加抢购数量
     * 
     * @return int
     */
    public function getPanicNum()
    {
        return $this->panicNum;
    }

    /**
     * 抢购价格
     * 
     * @return mixed
     */
    public function getPanicPrice()
    {
        return $this->panicPrice;
    }

    /**
     * 抢购标题
     * 
     * @return string
     */
    public function getPanicTitle()
    {
        return $this->panicTitle;
    }

    /**
     * 限购数量
     * 
     * @return int
     */
    public function getQuantityLimit()
    {
        return $this->quantityLimit;
    }

    /**
     * 开始时间
     * 
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * 审核状态【0拒绝，1通过，2审核中】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺【编号】
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
