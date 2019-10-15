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
 * 商品图片表
 *
 * @Entity()
 * @Table(name="mg_goods_images")
 * 
 * @uses DbGoodsImages
 */
class DbGoodsImages extends Model
{

    /**
     *
     * @var int $goodsId 商品id
     *      @Column(name="goods_id", type="integer", default=0)
     */
    private $goodsId;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isThumb 缩略图【1是 0否】
     *      @Column(name="is_thumb", type="tinyint", default=0)
     */
    private $isThumb;

    /**
     *
     * @var string $picUrl 商品图片
     *      @Column(name="pic_url", type="string", length=200)
     */
    private $picUrl;

    /**
     *
     * @var int $status 展示图片 1 是；0否
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

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
     * 缩略图【1是 0否】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsThumb(int $value): self
    {
        $this->isThumb = $value;
        
        return $this;
    }

    /**
     * 商品图片
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
     * 展示图片 1 是；0否
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
     * 商品id
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
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
     * 缩略图【1是 0否】
     * 
     * @return int
     */
    public function getIsThumb()
    {
        return $this->isThumb;
    }

    /**
     * 商品图片
     * 
     * @return string
     */
    public function getPicUrl()
    {
        return $this->picUrl;
    }

    /**
     * 展示图片 1 是；0否
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
