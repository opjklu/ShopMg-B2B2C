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
 * 商品 - 属性 对应表
 *
 * @Entity()
 * @Table(name="mg_goods_attr")
 * 
 * @uses DbGoodsAttr
 */
class DbGoodsAttr extends Model
{

    /**
     *
     * @var string $attrPrice 属性价格
     *      @Column(name="attr_price", type="string", length=255, default="")
     */
    private $attrPrice;

    /**
     *
     * @var string $attrValue 属性值
     *      @Column(name="attr_value", type="text", length=65535)
     *      @Required()
     */
    private $attrValue;

    /**
     *
     * @var int $attributeId 商品属性编号
     *      @Column(name="attribute_id", type="integer", default=0)
     */
    private $attributeId;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

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
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="integer", default=0)
     */
    private $updateTime;

    /**
     * 属性价格
     * 
     * @param string $value            
     * @return $this
     */
    public function setAttrPrice(string $value): self
    {
        $this->attrPrice = $value;
        
        return $this;
    }

    /**
     * 属性值
     * 
     * @param string $value            
     * @return $this
     */
    public function setAttrValue(string $value): self
    {
        $this->attrValue = $value;
        
        return $this;
    }

    /**
     * 商品属性编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setAttributeId(int $value): self
    {
        $this->attributeId = $value;
        
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
     * 属性价格
     * 
     * @return string
     */
    public function getAttrPrice()
    {
        return $this->attrPrice;
    }

    /**
     * 属性值
     * 
     * @return string
     */
    public function getAttrValue()
    {
        return $this->attrValue;
    }

    /**
     * 商品属性编号
     * 
     * @return int
     */
    public function getAttributeId()
    {
        return $this->attributeId;
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
     * 更新时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
