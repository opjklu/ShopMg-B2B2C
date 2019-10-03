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
 * 导航图片表
 *
 * @Entity()
 * @Table(name="mg_nav_img")
 * 
 * @uses DbNavImg
 */
class DbNavImg extends Model
{

    /**
     *
     * @var int $goodsId 商品id
     *      @Column(name="goods_id", type="integer")
     */
    private $goodsId;

    /**
     *
     * @var int $imgType 板块图片类型：1代表第1块的图片，2代表第二块的上传图片1,3代表第2块的上传图片2，4代码第3块的上传图片，5代表第4块的上传图片1,6代表第4块的上传图片2
     *      @Column(name="img_type", type="integer")
     */
    private $imgType;

    /**
     *
     * @var string $imgUrl 图片地址
     *      @Column(name="img_url", type="string", length=50)
     */
    private $imgUrl;

    /**
     *
     * @var string $navType 导航规格类型
     *      @Column(name="nav_type", type="string", length=50)
     *      @Required()
     */
    private $navType;

    /**
     *
     * @var int $titleType 标题类型
     *      @Column(name="title_type", type="integer", default=0)
     */
    private $titleType;

    /**
     * 商品id
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
     * 板块图片类型：1代表第1块的图片，2代表第二块的上传图片1,3代表第2块的上传图片2，4代码第3块的上传图片，5代表第4块的上传图片1,6代表第4块的上传图片2
     * 
     * @param int $value            
     * @return $this
     */
    public function setImgType(int $value): self
    {
        $this->imgType = $value;
        
        return $this;
    }

    /**
     * 图片地址
     * 
     * @param string $value            
     * @return $this
     */
    public function setImgUrl(string $value): self
    {
        $this->imgUrl = $value;
        
        return $this;
    }

    /**
     * 导航规格类型
     * 
     * @param string $value            
     * @return $this
     */
    public function setNavType(string $value): self
    {
        $this->navType = $value;
        
        return $this;
    }

    /**
     * 标题类型
     * 
     * @param int $value            
     * @return $this
     */
    public function setTitleType(int $value): self
    {
        $this->titleType = $value;
        
        return $this;
    }

    /**
     * 商品id
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 板块图片类型：1代表第1块的图片，2代表第二块的上传图片1,3代表第2块的上传图片2，4代码第3块的上传图片，5代表第4块的上传图片1,6代表第4块的上传图片2
     * 
     * @return int
     */
    public function getImgType()
    {
        return $this->imgType;
    }

    /**
     * 图片地址
     * 
     * @return string
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * 导航规格类型
     * 
     * @return string
     */
    public function getNavType()
    {
        return $this->navType;
    }

    /**
     * 标题类型
     * 
     * @return int
     */
    public function getTitleType()
    {
        return $this->titleType;
    }
}
