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
 * 广告表
 *
 * @Entity()
 * @Table(name="mg_ad")
 * 
 * @uses DbAd
 */
class DbAd extends Model
{

    /**
     *
     * @var string $adLink 广告链接
     *      @Column(name="ad_link", type="string", length=100)
     */
    private $adLink;

    /**
     *
     * @var int $adSpaceId 广告类型id
     *      @Column(name="ad_space_id", type="integer")
     */
    private $adSpaceId;

    /**
     *
     * @var string $colorVal 颜色值
     *      @Column(name="color_val", type="string", length=8)
     */
    private $colorVal;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $enabled 0, 不启用; 1,启用
     *      @Column(name="enabled", type="tinyint", default=0)
     */
    private $enabled;

    /**
     *
     * @var int $endTime 广告结束显示时间
     *      @Column(name="end_time", type="integer", default=0)
     */
    private $endTime;

    /**
     *
     * @var int $hitNum 广告点击次数
     *      @Column(name="hit_num", type="integer", default=0)
     */
    private $hitNum;

    /**
     *
     * @var int $id id编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $picUrl 图片路径
     *      @Column(name="pic_url", type="string", length=50)
     */
    private $picUrl;

    /**
     *
     * @var int $platform 显示在哪个平台:0.电脑1.wap.2 app
     *      @Column(name="platform", type="tinyint", default=0)
     */
    private $platform;

    /**
     *
     * @var int $sortNum 排序
     *      @Column(name="sort_num", type="tinyint", default=50)
     */
    private $sortNum;

    /**
     *
     * @var int $startTime 广告开始显示时间
     *      @Column(name="start_time", type="integer", default=0)
     */
    private $startTime;

    /**
     *
     * @var string $title 广告标题
     *      @Column(name="title", type="string", length=20)
     */
    private $title;

    /**
     *
     * @var int $type 该字段 暂时废弃
     *      @Column(name="type", type="tinyint")
     */
    private $type;

    /**
     *
     * @var int $updateTime 修改时间
     *      @Column(name="update_time", type="integer")
     */
    private $updateTime;

    /**
     * 广告链接
     * 
     * @param string $value            
     * @return $this
     */
    public function setAdLink(string $value): self
    {
        $this->adLink = $value;
        
        return $this;
    }

    /**
     * 广告类型id
     * 
     * @param int $value            
     * @return $this
     */
    public function setAdSpaceId(int $value): self
    {
        $this->adSpaceId = $value;
        
        return $this;
    }

    /**
     * 颜色值
     * 
     * @param string $value            
     * @return $this
     */
    public function setColorVal(string $value): self
    {
        $this->colorVal = $value;
        
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
     * 0, 不启用; 1,启用
     * 
     * @param int $value            
     * @return $this
     */
    public function setEnabled(int $value): self
    {
        $this->enabled = $value;
        
        return $this;
    }

    /**
     * 广告结束显示时间
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
     * 广告点击次数
     * 
     * @param int $value            
     * @return $this
     */
    public function setHitNum(int $value): self
    {
        $this->hitNum = $value;
        
        return $this;
    }

    /**
     * id编号
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
     * 图片路径
     * 
     * @param string $value            
     * @return $this
     */
    public function setPicUrl(string $value): self
    {
        $this->picUrl = $value;
        
        return $this;
    }

    /**
     * 显示在哪个平台:0.电脑1.wap.2 app
     * 
     * @param int $value            
     * @return $this
     */
    public function setPlatform(int $value): self
    {
        $this->platform = $value;
        
        return $this;
    }

    /**
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setSortNum(int $value): self
    {
        $this->sortNum = $value;
        
        return $this;
    }

    /**
     * 广告开始显示时间
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
     * 广告标题
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
     * 该字段 暂时废弃
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
     * 广告链接
     * 
     * @return string
     */
    public function getAdLink()
    {
        return $this->adLink;
    }

    /**
     * 广告类型id
     * 
     * @return int
     */
    public function getAdSpaceId()
    {
        return $this->adSpaceId;
    }

    /**
     * 颜色值
     * 
     * @return string
     */
    public function getColorVal()
    {
        return $this->colorVal;
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
     * 0, 不启用; 1,启用
     * 
     * @return int
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * 广告结束显示时间
     * 
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * 广告点击次数
     * 
     * @return int
     */
    public function getHitNum()
    {
        return $this->hitNum;
    }

    /**
     * id编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 图片路径
     * 
     * @return string
     */
    public function getPicUrl()
    {
        return $this->picUrl;
    }

    /**
     * 显示在哪个平台:0.电脑1.wap.2 app
     * 
     * @return int
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * 排序
     * 
     * @return mixed
     */
    public function getSortNum()
    {
        return $this->sortNum;
    }

    /**
     * 广告开始显示时间
     * 
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * 广告标题
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 该字段 暂时废弃
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
