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
 * 团购商品表
 *
 * @Entity()
 * @Table(name="mg_group")
 * 
 * @uses DbGroup
 */
class DbGroup extends Model
{

    /**
     *
     * @var int $auditingStatus 审核状态【 0拒绝 1为已审核，2审核中】
     *      @Column(name="auditing_status", type="tinyint", default=0)
     */
    private $auditingStatus;

    /**
     *
     * @var int $buyNum 商品已购买数
     *      @Column(name="buy_num", type="integer", default=0)
     */
    private $buyNum;

    /**
     *
     * @var int $createTime 添加时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var string $description 本团介绍
     *      @Column(name="description", type="text", length=65535)
     */
    private $description;

    /**
     *
     * @var int $endTime 结束时间
     *      @Column(name="end_time", type="integer", default=0)
     */
    private $endTime;

    /**
     *
     * @var int $goodsId 商品ID
     *      @Column(name="goods_id", type="integer", default=0)
     */
    private $goodsId;

    /**
     *
     * @var int $goodsNum 商品参团数
     *      @Column(name="goods_num", type="integer", default=0)
     */
    private $goodsNum;

    /**
     *
     * @var int $id 团购ID
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $lookNum 查看次数
     *      @Column(name="look_num", type="integer", default=0)
     */
    private $lookNum;

    /**
     *
     * @var int $orderNum 已下单人数
     *      @Column(name="order_num", type="integer", default=0)
     */
    private $orderNum;

    /**
     *
     * @var float $price 团购价格
     *      @Column(name="price", type="decimal")
     *      @Required()
     */
    private $price;

    /**
     *
     * @var int $recommended 是否推荐 0.未推荐 1.已推荐
     *      @Column(name="recommended", type="tinyint")
     *      @Required()
     */
    private $recommended;

    /**
     *
     * @var int $startTime 开始时间
     *      @Column(name="start_time", type="integer", default=0)
     */
    private $startTime;

    /**
     *
     * @var int $storeId 店铺id
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var string $title 活动名称
     *      @Column(name="title", type="string", length=50)
     *      @Required()
     */
    private $title;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $virtualNum 虚拟购买数
     *      @Column(name="virtual_num", type="integer", default=0)
     */
    private $virtualNum;

    /**
     * 审核状态【 0拒绝 1为已审核，2审核中】
     * 
     * @param int $value            
     * @return $this
     */
    public function setAuditingStatus(int $value): self
    {
        $this->auditingStatus = $value;
        
        return $this;
    }

    /**
     * 商品已购买数
     * 
     * @param int $value            
     * @return $this
     */
    public function setBuyNum(int $value): self
    {
        $this->buyNum = $value;
        
        return $this;
    }

    /**
     * 添加时间
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
     * 本团介绍
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
     * 商品参团数
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
     * 团购ID
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
     * 查看次数
     * 
     * @param int $value            
     * @return $this
     */
    public function setLookNum(int $value): self
    {
        $this->lookNum = $value;
        
        return $this;
    }

    /**
     * 已下单人数
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderNum(int $value): self
    {
        $this->orderNum = $value;
        
        return $this;
    }

    /**
     * 团购价格
     * 
     * @param float $value            
     * @return $this
     */
    public function setPrice(float $value): self
    {
        $this->price = $value;
        
        return $this;
    }

    /**
     * 是否推荐 0.未推荐 1.已推荐
     * 
     * @param int $value            
     * @return $this
     */
    public function setRecommended(int $value): self
    {
        $this->recommended = $value;
        
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
     * 活动名称
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
     * 虚拟购买数
     * 
     * @param int $value            
     * @return $this
     */
    public function setVirtualNum(int $value): self
    {
        $this->virtualNum = $value;
        
        return $this;
    }

    /**
     * 审核状态【 0拒绝 1为已审核，2审核中】
     * 
     * @return int
     */
    public function getAuditingStatus()
    {
        return $this->auditingStatus;
    }

    /**
     * 商品已购买数
     * 
     * @return int
     */
    public function getBuyNum()
    {
        return $this->buyNum;
    }

    /**
     * 添加时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 本团介绍
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * 商品ID
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 商品参团数
     * 
     * @return int
     */
    public function getGoodsNum()
    {
        return $this->goodsNum;
    }

    /**
     * 团购ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 查看次数
     * 
     * @return int
     */
    public function getLookNum()
    {
        return $this->lookNum;
    }

    /**
     * 已下单人数
     * 
     * @return int
     */
    public function getOrderNum()
    {
        return $this->orderNum;
    }

    /**
     * 团购价格
     * 
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * 是否推荐 0.未推荐 1.已推荐
     * 
     * @return int
     */
    public function getRecommended()
    {
        return $this->recommended;
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
     * 店铺id
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 活动名称
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * 虚拟购买数
     * 
     * @return int
     */
    public function getVirtualNum()
    {
        return $this->virtualNum;
    }
}
