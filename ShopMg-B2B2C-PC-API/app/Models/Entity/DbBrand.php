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
 * 品牌表
 *
 * @Entity()
 * @Table(name="mg_brand")
 * 
 * @uses DbBrand
 */
class DbBrand extends Model
{

    /**
     *
     * @var string $brandBanner 品牌banner
     *      @Column(name="brand_banner", type="string", length=150)
     */
    private $brandBanner;

    /**
     *
     * @var string $brandDescription 品牌描述
     *      @Column(name="brand_description", type="string", length=100)
     */
    private $brandDescription;

    /**
     *
     * @var string $brandLogo 品牌图片
     *      @Column(name="brand_logo", type="string", length=150)
     */
    private $brandLogo;

    /**
     *
     * @var string $brandName 品牌名称
     *      @Column(name="brand_name", type="string", length=20)
     */
    private $brandName;

    /**
     *
     * @var string $createTime 创建时间
     *      @Column(name="create_time", type="string", length=20)
     */
    private $createTime;

    /**
     *
     * @var int $goodsClassId 所属商品分类编号
     *      @Column(name="goods_class_id", type="integer")
     */
    private $goodsClassId;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $letter 品牌 字母
     *      @Column(name="letter", type="char", length=1)
     *      @Required()
     */
    private $letter;

    /**
     *
     * @var int $recommend 是否推荐【1推荐0不推荐】
     *      @Column(name="recommend", type="tinyint", default=0)
     */
    private $recommend;

    /**
     *
     * @var int $status 状态【0审核中， 1已通过， 2不通过】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $storeId 商家编号
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var string $updateTime 更新时间
     *      @Column(name="update_time", type="string", length=20)
     */
    private $updateTime;

    /**
     * 品牌banner
     * 
     * @param string $value            
     * @return $this
     */
    public function setBrandBanner(string $value): self
    {
        $this->brandBanner = $value;
        
        return $this;
    }

    /**
     * 品牌描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setBrandDescription(string $value): self
    {
        $this->brandDescription = $value;
        
        return $this;
    }

    /**
     * 品牌图片
     * 
     * @param string $value            
     * @return $this
     */
    public function setBrandLogo(string $value): self
    {
        $this->brandLogo = $value;
        
        return $this;
    }

    /**
     * 品牌名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setBrandName(string $value): self
    {
        $this->brandName = $value;
        
        return $this;
    }

    /**
     * 创建时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setCreateTime(string $value): self
    {
        $this->createTime = $value;
        
        return $this;
    }

    /**
     * 所属商品分类编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsClassId(int $value): self
    {
        $this->goodsClassId = $value;
        
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
     * 品牌 字母
     * 
     * @param string $value            
     * @return $this
     */
    public function setLetter(string $value): self
    {
        $this->letter = $value;
        
        return $this;
    }

    /**
     * 是否推荐【1推荐0不推荐】
     * 
     * @param int $value            
     * @return $this
     */
    public function setRecommend(int $value): self
    {
        $this->recommend = $value;
        
        return $this;
    }

    /**
     * 状态【0审核中， 1已通过， 2不通过】
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
     * 商家编号
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
     * @param string $value            
     * @return $this
     */
    public function setUpdateTime(string $value): self
    {
        $this->updateTime = $value;
        
        return $this;
    }

    /**
     * 品牌banner
     * 
     * @return string
     */
    public function getBrandBanner()
    {
        return $this->brandBanner;
    }

    /**
     * 品牌描述
     * 
     * @return string
     */
    public function getBrandDescription()
    {
        return $this->brandDescription;
    }

    /**
     * 品牌图片
     * 
     * @return string
     */
    public function getBrandLogo()
    {
        return $this->brandLogo;
    }

    /**
     * 品牌名称
     * 
     * @return string
     */
    public function getBrandName()
    {
        return $this->brandName;
    }

    /**
     * 创建时间
     * 
     * @return string
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 所属商品分类编号
     * 
     * @return int
     */
    public function getGoodsClassId()
    {
        return $this->goodsClassId;
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
     * 品牌 字母
     * 
     * @return string
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * 是否推荐【1推荐0不推荐】
     * 
     * @return int
     */
    public function getRecommend()
    {
        return $this->recommend;
    }

    /**
     * 状态【0审核中， 1已通过， 2不通过】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 商家编号
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
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
