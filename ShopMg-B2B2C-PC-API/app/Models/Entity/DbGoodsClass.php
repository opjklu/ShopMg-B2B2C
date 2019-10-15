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
 * 商品分类表
 *
 * @Entity()
 * @Table(name="mg_goods_class")
 * 
 * @uses DbGoodsClass
 */
class DbGoodsClass extends Model
{

    /**
     *
     * @var string $className 分类名字
     *      @Column(name="class_name", type="string", length=20)
     */
    private $className;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var string $cssClass css样式
     *      @Column(name="css_class", type="string", length=50)
     */
    private $cssClass;

    /**
     *
     * @var string $description 分类介绍
     *      @Column(name="description", type="string", length=50)
     */
    private $description;

    /**
     *
     * @var int $fid 父id
     *      @Column(name="fid", type="integer", default=0)
     */
    private $fid;

    /**
     *
     * @var int $hideStatus 是否显示【1 显示 0隐藏】
     *      @Column(name="hide_status", type="tinyint")
     */
    private $hideStatus;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isShowNav 是否显示在导航栏0：是；1：否
     *      @Column(name="is_show_nav", type="tinyint", default=0)
     */
    private $isShowNav;

    /**
     *
     * @var string $pcUrl pc 广告分类图
     *      @Column(name="pc_url", type="string", length=60)
     */
    private $pcUrl;

    /**
     *
     * @var string $picUrl 图片
     *      @Column(name="pic_url", type="string", length=150)
     */
    private $picUrl;

    /**
     *
     * @var int $shoutui 是否推荐【1 为推荐 0为不推荐】
     *      @Column(name="shoutui", type="tinyint", default=0)
     */
    private $shoutui;

    /**
     *
     * @var int $sortNum 排序
     *      @Column(name="sort_num", type="tinyint", default=50)
     */
    private $sortNum;

    /**
     *
     * @var string $type 1为商品 2旅游 3合伙人 4会员
     *      @Column(name="type", type="string", length=1)
     */
    private $type;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer")
     */
    private $updateTime;

    /**
     * 分类名字
     * 
     * @param string $value            
     * @return $this
     */
    public function setClassName(string $value): self
    {
        $this->className = $value;
        
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
     * css样式
     * 
     * @param string $value            
     * @return $this
     */
    public function setCssClass(string $value): self
    {
        $this->cssClass = $value;
        
        return $this;
    }

    /**
     * 分类介绍
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
     * 父id
     * 
     * @param int $value            
     * @return $this
     */
    public function setFid(int $value): self
    {
        $this->fid = $value;
        
        return $this;
    }

    /**
     * 是否显示【1 显示 0隐藏】
     * 
     * @param int $value            
     * @return $this
     */
    public function setHideStatus(int $value): self
    {
        $this->hideStatus = $value;
        
        return $this;
    }

    /**
     * 热卖单品【1表示是，2表示否】
     * 
     * @param int $value            
     * @return $this
     */
    public function setHotSingle(int $value): self
    {
        $this->hotSingle = $value;
        
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
     * 是否办公硬件推荐【1表示是，0表示否】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsHardware(int $value): self
    {
        $this->isHardware = $value;
        
        return $this;
    }

    /**
     * 是否推荐打印耗材【1表示是，0表示否】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsPrinting(int $value): self
    {
        $this->isPrinting = $value;
        
        return $this;
    }

    /**
     * 是否显示在导航栏0：是；1：否
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsShowNav(int $value): self
    {
        $this->isShowNav = $value;
        
        return $this;
    }

    /**
     * pc 广告分类图
     * 
     * @param string $value            
     * @return $this
     */
    public function setPcUrl(string $value): self
    {
        $this->pcUrl = $value;
        
        return $this;
    }

    /**
     * 图片
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
     * 是否推荐【1 为推荐 0为不推荐】
     * 
     * @param int $value            
     * @return $this
     */
    public function setShoutui(int $value): self
    {
        $this->shoutui = $value;
        
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
     * 1为商品 2旅游 3合伙人 4会员
     * 
     * @param string $value            
     * @return $this
     */
    public function setType(string $value): self
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
     * 分类名字
     * 
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
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
     * css样式
     * 
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * 分类介绍
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 父id
     * 
     * @return int
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * 是否显示【1 显示 0隐藏】
     * 
     * @return int
     */
    public function getHideStatus()
    {
        return $this->hideStatus;
    }

    /**
     * 热卖单品【1表示是，2表示否】
     * 
     * @return int
     */
    public function getHotSingle()
    {
        return $this->hotSingle;
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
     * 是否办公硬件推荐【1表示是，0表示否】
     * 
     * @return int
     */
    public function getIsHardware()
    {
        return $this->isHardware;
    }

    /**
     * 是否推荐打印耗材【1表示是，0表示否】
     * 
     * @return int
     */
    public function getIsPrinting()
    {
        return $this->isPrinting;
    }

    /**
     * 是否显示在导航栏0：是；1：否
     * 
     * @return int
     */
    public function getIsShowNav()
    {
        return $this->isShowNav;
    }

    /**
     * pc 广告分类图
     * 
     * @return string
     */
    public function getPcUrl()
    {
        return $this->pcUrl;
    }

    /**
     * 图片
     * 
     * @return string
     */
    public function getPicUrl()
    {
        return $this->picUrl;
    }

    /**
     * 是否推荐【1 为推荐 0为不推荐】
     * 
     * @return int
     */
    public function getShoutui()
    {
        return $this->shoutui;
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
     * 1为商品 2旅游 3合伙人 4会员
     * 
     * @return string
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
