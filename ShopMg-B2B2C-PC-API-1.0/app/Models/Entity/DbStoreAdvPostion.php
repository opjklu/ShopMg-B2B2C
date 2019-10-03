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
 * 店铺广告位表
 *
 * @Entity()
 * @Table(name="mg_store_adv_postion")
 * 
 * @uses DbStoreAdvPostion
 */
class DbStoreAdvPostion extends Model
{

    /**
     *
     * @var int $advNum 拥有的广告数
     *      @Column(name="adv_num", type="integer")
     *      @Required()
     */
    private $advNum;

    /**
     *
     * @var int $apClass 广告类别【0图片1文字2幻灯3Flash】
     *      @Column(name="ap_class", type="smallint")
     *      @Required()
     */
    private $apClass;

    /**
     *
     * @var int $apDisplay 广告展示方式：0幻灯片1多广告展示2单广告展示
     *      @Column(name="ap_display", type="smallint")
     *      @Required()
     */
    private $apDisplay;

    /**
     *
     * @var int $apHeight 广告位高度
     *      @Column(name="ap_height", type="integer")
     *      @Required()
     */
    private $apHeight;

    /**
     *
     * @var string $apName 广告位置名
     *      @Column(name="ap_name", type="string", length=100)
     *      @Required()
     */
    private $apName;

    /**
     *
     * @var int $apWidth 广告位宽度
     *      @Column(name="ap_width", type="integer")
     *      @Required()
     */
    private $apWidth;

    /**
     *
     * @var int $clickNum 广告位点击率
     *      @Column(name="click_num", type="integer")
     *      @Required()
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
     * @var string $defaultContent 广告位默认内容
     *      @Column(name="default_content", type="string", length=100)
     *      @Required()
     */
    private $defaultContent;

    /**
     *
     * @var int $id 广告位置id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isUse 广告位是否启用：0不启用1启用
     *      @Column(name="is_use", type="smallint")
     *      @Required()
     */
    private $isUse;

    /**
     *
     * @var int $maxHeight 最小高度
     *      @Column(name="max_height", type="smallint")
     *      @Required()
     */
    private $maxHeight;

    /**
     *
     * @var int $maxWidth 最大宽度
     *      @Column(name="max_width", type="smallint")
     *      @Required()
     */
    private $maxWidth;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     * 拥有的广告数
     * 
     * @param int $value            
     * @return $this
     */
    public function setAdvNum(int $value): self
    {
        $this->advNum = $value;
        
        return $this;
    }

    /**
     * 广告类别【0图片1文字2幻灯3Flash】
     * 
     * @param int $value            
     * @return $this
     */
    public function setApClass(int $value): self
    {
        $this->apClass = $value;
        
        return $this;
    }

    /**
     * 广告展示方式：0幻灯片1多广告展示2单广告展示
     * 
     * @param int $value            
     * @return $this
     */
    public function setApDisplay(int $value): self
    {
        $this->apDisplay = $value;
        
        return $this;
    }

    /**
     * 广告位高度
     * 
     * @param int $value            
     * @return $this
     */
    public function setApHeight(int $value): self
    {
        $this->apHeight = $value;
        
        return $this;
    }

    /**
     * 广告位置名
     * 
     * @param string $value            
     * @return $this
     */
    public function setApName(string $value): self
    {
        $this->apName = $value;
        
        return $this;
    }

    /**
     * 广告位宽度
     * 
     * @param int $value            
     * @return $this
     */
    public function setApWidth(int $value): self
    {
        $this->apWidth = $value;
        
        return $this;
    }

    /**
     * 广告位点击率
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
     * 广告位默认内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setDefaultContent(string $value): self
    {
        $this->defaultContent = $value;
        
        return $this;
    }

    /**
     * 广告位置id
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
     * 广告位是否启用：0不启用1启用
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsUse(int $value): self
    {
        $this->isUse = $value;
        
        return $this;
    }

    /**
     * 最小高度
     * 
     * @param int $value            
     * @return $this
     */
    public function setMaxHeight(int $value): self
    {
        $this->maxHeight = $value;
        
        return $this;
    }

    /**
     * 最大宽度
     * 
     * @param int $value            
     * @return $this
     */
    public function setMaxWidth(int $value): self
    {
        $this->maxWidth = $value;
        
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
     * 拥有的广告数
     * 
     * @return int
     */
    public function getAdvNum()
    {
        return $this->advNum;
    }

    /**
     * 广告类别【0图片1文字2幻灯3Flash】
     * 
     * @return int
     */
    public function getApClass()
    {
        return $this->apClass;
    }

    /**
     * 广告展示方式：0幻灯片1多广告展示2单广告展示
     * 
     * @return int
     */
    public function getApDisplay()
    {
        return $this->apDisplay;
    }

    /**
     * 广告位高度
     * 
     * @return int
     */
    public function getApHeight()
    {
        return $this->apHeight;
    }

    /**
     * 广告位置名
     * 
     * @return string
     */
    public function getApName()
    {
        return $this->apName;
    }

    /**
     * 广告位宽度
     * 
     * @return int
     */
    public function getApWidth()
    {
        return $this->apWidth;
    }

    /**
     * 广告位点击率
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
     * 广告位默认内容
     * 
     * @return string
     */
    public function getDefaultContent()
    {
        return $this->defaultContent;
    }

    /**
     * 广告位置id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 广告位是否启用：0不启用1启用
     * 
     * @return int
     */
    public function getIsUse()
    {
        return $this->isUse;
    }

    /**
     * 最小高度
     * 
     * @return int
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * 最大宽度
     * 
     * @return int
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
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
