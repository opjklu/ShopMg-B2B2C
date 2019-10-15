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
 * 促销活动表
 *
 * @Entity()
 * @Table(name="mg_prom_goods")
 * 
 * @uses DbPromGoods
 */
class DbPromGoods extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var string $description 活动描述
     *      @Column(name="description", type="text", length=65535)
     */
    private $description;

    /**
     *
     * @var int $endTime 活动结束时间
     *      @Column(name="end_time", type="integer")
     *      @Required()
     */
    private $endTime;

    /**
     *
     * @var int $expression 优惠体现
     *      @Column(name="expression", type="integer", default=0)
     */
    private $expression;

    /**
     *
     * @var int $full 满多少
     *      @Column(name="full", type="integer", default=0)
     */
    private $full;

    /**
     *
     * @var string $group 适用范围
     *      @Column(name="group", type="string", length=255, default="0")
     */
    private $group;

    /**
     *
     * @var int $id 活动ID
     *      @Id()
     *      @Column(name="id", type="bigint")
     */
    private $id;

    /**
     *
     * @var int $limitBuy 限购数量
     *      @Column(name="limit_buy", type="integer", default=0)
     */
    private $limitBuy;

    /**
     *
     * @var string $name 促销活动名称
     *      @Column(name="name", type="string", length=60)
     *      @Required()
     */
    private $name;

    /**
     *
     * @var int $panicBuy 抢购数量
     *      @Column(name="panic_buy", type="integer", default=0)
     */
    private $panicBuy;

    /**
     *
     * @var string $promImg 活动宣传图片
     *      @Column(name="prom_img", type="string", length=150)
     */
    private $promImg;

    /**
     *
     * @var int $startTime 活动开始时间
     *      @Column(name="start_time", type="integer")
     *      @Required()
     */
    private $startTime;

    /**
     *
     * @var int $status 活动状态 1 开启 0 关闭
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺id
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $type 促销类型
     *      @Column(name="type", type="integer", default=0)
     */
    private $type;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer", default=0)
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
     * 活动描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setDescription(string $value): self
    {
        $this->description = $value;
        
        return $this;
    }

    /**
     * 活动结束时间
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
     * 优惠体现
     * 
     * @param int $value            
     * @return $this
     */
    public function setExpression(int $value): self
    {
        $this->expression = $value;
        
        return $this;
    }

    /**
     * 满多少
     * 
     * @param int $value            
     * @return $this
     */
    public function setFull(int $value): self
    {
        $this->full = $value;
        
        return $this;
    }

    /**
     * 适用范围
     * 
     * @param string $value            
     * @return $this
     */
    public function setGroup(string $value): self
    {
        $this->group = $value;
        
        return $this;
    }

    /**
     * 活动ID
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
     * 限购数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setLimitBuy(int $value): self
    {
        $this->limitBuy = $value;
        
        return $this;
    }

    /**
     * 促销活动名称
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
     * 抢购数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setPanicBuy(int $value): self
    {
        $this->panicBuy = $value;
        
        return $this;
    }

    /**
     * 活动宣传图片
     * 
     * @param string $value            
     * @return $this
     */
    public function setPromImg(string $value): self
    {
        $this->promImg = $value;
        
        return $this;
    }

    /**
     * 活动开始时间
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
     * 活动状态 1 开启 0 关闭
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
     * 促销类型
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 活动描述
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 活动结束时间
     * 
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * 优惠体现
     * 
     * @return int
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * 满多少
     * 
     * @return int
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * 适用范围
     * 
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * 活动ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 限购数量
     * 
     * @return int
     */
    public function getLimitBuy()
    {
        return $this->limitBuy;
    }

    /**
     * 促销活动名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 抢购数量
     * 
     * @return int
     */
    public function getPanicBuy()
    {
        return $this->panicBuy;
    }

    /**
     * 活动宣传图片
     * 
     * @return string
     */
    public function getPromImg()
    {
        return $this->promImg;
    }

    /**
     * 活动开始时间
     * 
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * 活动状态 1 开启 0 关闭
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
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
     * 促销类型
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
}
