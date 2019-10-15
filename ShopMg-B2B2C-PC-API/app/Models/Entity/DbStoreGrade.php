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
 * 店铺等级表
 *
 * @Entity()
 * @Table(name="mg_store_grade")
 * 
 * @uses DbStoreGrade
 */
class DbStoreGrade extends Model
{

    /**
     *
     * @var int $albumList 允许上传图片数量
     *      @Column(name="album_list", type="integer")
     *      @Required()
     */
    private $albumList;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var string $description 申请说明
     *      @Column(name="description", type="string", length=100)
     */
    private $description;

    /**
     *
     * @var int $goodsLimit 允许发布的商品数量
     *      @Column(name="goods_limit", type="integer")
     *      @Required()
     */
    private $goodsLimit;

    /**
     *
     * @var int $id 索引ID
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $levelName 等级名称
     *      @Column(name="level_name", type="string", length=50)
     *      @Required()
     */
    private $levelName;

    /**
     *
     * @var float $lowerLimit 销售下限金额
     *      @Column(name="lower_limit", type="decimal", default=0)
     */
    private $lowerLimit;

    /**
     *
     * @var float $price 开店费用(元/年)
     *      @Column(name="price", type="decimal")
     */
    private $price;

    /**
     *
     * @var int $spaceLimit 上传空间大小【单位MB】
     *      @Column(name="space_limit", type="integer")
     */
    private $spaceLimit;

    /**
     *
     * @var int $status 是否启用【0否1是】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $templateNumber 选择店铺模板套数
     *      @Column(name="template_number", type="integer", default=0)
     */
    private $templateNumber;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var float $upperLimit 销售上限
     *      @Column(name="upper_limit", type="decimal", default=0)
     */
    private $upperLimit;

    /**
     * 允许上传图片数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setAlbumList(int $value): self
    {
        $this->albumList = $value;
        
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
     * 申请说明
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
     * 允许发布的商品数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsLimit(int $value): self
    {
        $this->goodsLimit = $value;
        
        return $this;
    }

    /**
     * 索引ID
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
     * 等级名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setLevelName(string $value): self
    {
        $this->levelName = $value;
        
        return $this;
    }

    /**
     * 销售下限金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setLowerLimit(float $value): self
    {
        $this->lowerLimit = $value;
        
        return $this;
    }

    /**
     * 开店费用(元/年)
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
     * 上传空间大小【单位MB】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSpaceLimit(int $value): self
    {
        $this->spaceLimit = $value;
        
        return $this;
    }

    /**
     * 是否启用【0否1是】
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
     * 选择店铺模板套数
     * 
     * @param int $value            
     * @return $this
     */
    public function setTemplateNumber(int $value): self
    {
        $this->templateNumber = $value;
        
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
     * 销售上限
     * 
     * @param float $value            
     * @return $this
     */
    public function setUpperLimit(float $value): self
    {
        $this->upperLimit = $value;
        
        return $this;
    }

    /**
     * 允许上传图片数量
     * 
     * @return int
     */
    public function getAlbumList()
    {
        return $this->albumList;
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
     * 申请说明
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 允许发布的商品数量
     * 
     * @return int
     */
    public function getGoodsLimit()
    {
        return $this->goodsLimit;
    }

    /**
     * 索引ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 等级名称
     * 
     * @return string
     */
    public function getLevelName()
    {
        return $this->levelName;
    }

    /**
     * 销售下限金额
     * 
     * @return mixed
     */
    public function getLowerLimit()
    {
        return $this->lowerLimit;
    }

    /**
     * 开店费用(元/年)
     * 
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * 上传空间大小【单位MB】
     * 
     * @return int
     */
    public function getSpaceLimit()
    {
        return $this->spaceLimit;
    }

    /**
     * 是否启用【0否1是】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 选择店铺模板套数
     * 
     * @return int
     */
    public function getTemplateNumber()
    {
        return $this->templateNumber;
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
     * 销售上限
     * 
     * @return mixed
     */
    public function getUpperLimit()
    {
        return $this->upperLimit;
    }
}
