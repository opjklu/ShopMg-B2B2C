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
 * 店铺广告表
 *
 * @Entity()
 * @Table(name="mg_store_adv")
 * 
 * @uses DbStoreAdv
 */
class DbStoreAdv extends Model
{

    /**
     *
     * @var string $adKey 广告键
     *      @Column(name="ad_key", type="string", length=50)
     */
    private $adKey;

    /**
     *
     * @var string $adUrl 广告链接
     *      @Column(name="ad_url", type="string", length=150)
     */
    private $adUrl;

    /**
     *
     * @var string $advContent 广告内容
     *      @Column(name="adv_content", type="string", length=80)
     *      @Required()
     */
    private $advContent;

    /**
     *
     * @var int $advEndDate 广告结束时间
     *      @Column(name="adv_end_date", type="bigint")
     */
    private $advEndDate;

    /**
     *
     * @var int $advStartDate 广告开始时间
     *      @Column(name="adv_start_date", type="bigint")
     */
    private $advStartDate;

    /**
     *
     * @var string $advTitle 广告内容描述
     *      @Column(name="adv_title", type="string", length=255)
     *      @Required()
     */
    private $advTitle;

    /**
     *
     * @var int $apId 广告位id
     *      @Column(name="ap_id", type="integer")
     *      @Required()
     */
    private $apId;

    /**
     *
     * @var int $buyStyle 购买方式
     *      @Column(name="buy_style", type="tinyint")
     */
    private $buyStyle;

    /**
     *
     * @var int $clickNum 广告点击率
     *      @Column(name="click_num", type="integer", default=0)
     */
    private $clickNum;

    /**
     *
     * @var int $createTime 添加时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $goldpay 购买所支付的金币
     *      @Column(name="goldpay", type="integer", default=0)
     */
    private $goldpay;

    /**
     *
     * @var int $id 广告自增标识编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isAllow 会员购买的广告是否通过审核【0未审核1审核已通过2审核未通过】
     *      @Column(name="is_allow", type="smallint", default=0)
     */
    private $isAllow;

    /**
     *
     * @var int $slideSort 幻灯片排序
     *      @Column(name="slide_sort", type="integer")
     *      @Required()
     */
    private $slideSort;

    /**
     *
     * @var int $status 是否显示0显示1不显示
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺【ID】
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     * 广告键
     * 
     * @param string $value            
     * @return $this
     */
    public function setAdKey(string $value): self
    {
        $this->adKey = $value;
        
        return $this;
    }

    /**
     * 广告链接
     * 
     * @param string $value            
     * @return $this
     */
    public function setAdUrl(string $value): self
    {
        $this->adUrl = $value;
        
        return $this;
    }

    /**
     * 广告内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setAdvContent(string $value): self
    {
        $this->advContent = $value;
        
        return $this;
    }

    /**
     * 广告结束时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setAdvEndDate(int $value): self
    {
        $this->advEndDate = $value;
        
        return $this;
    }

    /**
     * 广告开始时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setAdvStartDate(int $value): self
    {
        $this->advStartDate = $value;
        
        return $this;
    }

    /**
     * 广告内容描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setAdvTitle(string $value): self
    {
        $this->advTitle = $value;
        
        return $this;
    }

    /**
     * 广告位id
     * 
     * @param int $value            
     * @return $this
     */
    public function setApId(int $value): self
    {
        $this->apId = $value;
        
        return $this;
    }

    /**
     * 购买方式
     * 
     * @param int $value            
     * @return $this
     */
    public function setBuyStyle(int $value): self
    {
        $this->buyStyle = $value;
        
        return $this;
    }

    /**
     * 广告点击率
     * 
     * @param int $value            
     * @return $this
     */
    public function setClickNum(int $value): self
    {
        $this->clickNum = $value;
        
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
     * 购买所支付的金币
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoldpay(int $value): self
    {
        $this->goldpay = $value;
        
        return $this;
    }

    /**
     * 广告自增标识编号
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
     * 会员购买的广告是否通过审核【0未审核1审核已通过2审核未通过】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsAllow(int $value): self
    {
        $this->isAllow = $value;
        
        return $this;
    }

    /**
     * 幻灯片排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setSlideSort(int $value): self
    {
        $this->slideSort = $value;
        
        return $this;
    }

    /**
     * 是否显示0显示1不显示
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
     * 店铺【ID】
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
     * 广告键
     * 
     * @return string
     */
    public function getAdKey()
    {
        return $this->adKey;
    }

    /**
     * 广告链接
     * 
     * @return string
     */
    public function getAdUrl()
    {
        return $this->adUrl;
    }

    /**
     * 广告内容
     * 
     * @return string
     */
    public function getAdvContent()
    {
        return $this->advContent;
    }

    /**
     * 广告结束时间
     * 
     * @return int
     */
    public function getAdvEndDate()
    {
        return $this->advEndDate;
    }

    /**
     * 广告开始时间
     * 
     * @return int
     */
    public function getAdvStartDate()
    {
        return $this->advStartDate;
    }

    /**
     * 广告内容描述
     * 
     * @return string
     */
    public function getAdvTitle()
    {
        return $this->advTitle;
    }

    /**
     * 广告位id
     * 
     * @return int
     */
    public function getApId()
    {
        return $this->apId;
    }

    /**
     * 购买方式
     * 
     * @return int
     */
    public function getBuyStyle()
    {
        return $this->buyStyle;
    }

    /**
     * 广告点击率
     * 
     * @return int
     */
    public function getClickNum()
    {
        return $this->clickNum;
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
     * 购买所支付的金币
     * 
     * @return int
     */
    public function getGoldpay()
    {
        return $this->goldpay;
    }

    /**
     * 广告自增标识编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 会员购买的广告是否通过审核【0未审核1审核已通过2审核未通过】
     * 
     * @return int
     */
    public function getIsAllow()
    {
        return $this->isAllow;
    }

    /**
     * 幻灯片排序
     * 
     * @return int
     */
    public function getSlideSort()
    {
        return $this->slideSort;
    }

    /**
     * 是否显示0显示1不显示
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺【ID】
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
