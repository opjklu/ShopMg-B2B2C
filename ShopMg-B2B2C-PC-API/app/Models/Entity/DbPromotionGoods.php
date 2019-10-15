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
 * 促销商品表
 *
 * @Entity()
 * @Table(name="mg_promotion_goods")
 * 
 * @uses DbPromotionGoods
 */
class DbPromotionGoods extends Model
{

    /**
     *
     * @var float $activityPrice 促销价格
     *      @Column(name="activity_price", type="decimal", default=0)
     */
    private $activityPrice;

    /**
     *
     * @var int $endTime 促销结束时间
     *      @Column(name="end_time", type="integer", default=0)
     */
    private $endTime;

    /**
     *
     * @var int $goodsId 商品编号
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
     * @var int $promId 促销编号
     *      @Column(name="prom_id", type="integer")
     *      @Required()
     */
    private $promId;

    /**
     *
     * @var int $startTime 促销开始时间
     *      @Column(name="start_time", type="integer", default=0)
     */
    private $startTime;

    /**
     * 促销价格
     * 
     * @param float $value            
     * @return $this
     */
    public function setActivityPrice(float $value): self
    {
        $this->activityPrice = $value;
        
        return $this;
    }

    /**
     * 促销结束时间
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
     * 促销编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setPromId(int $value): self
    {
        $this->promId = $value;
        
        return $this;
    }

    /**
     * 促销开始时间
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
     * 促销价格
     * 
     * @return mixed
     */
    public function getActivityPrice()
    {
        return $this->activityPrice;
    }

    /**
     * 促销结束时间
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
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 促销编号
     * 
     * @return int
     */
    public function getPromId()
    {
        return $this->promId;
    }

    /**
     * 促销开始时间
     * 
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }
}
