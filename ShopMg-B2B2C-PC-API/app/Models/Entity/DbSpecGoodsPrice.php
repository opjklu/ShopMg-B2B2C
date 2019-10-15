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
 * 商品规格属性表
 *
 * @Entity()
 * @Table(name="mg_spec_goods_price")
 * 
 * @uses DbSpecGoodsPrice
 */
class DbSpecGoodsPrice extends Model
{

    /**
     *
     * @var string $barCode 商品条形码
     *      @Column(name="bar_code", type="string", length=32, default="")
     */
    private $barCode;

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
     * @var string $key 规格键名
     *      @Column(name="key", type="string", length=50, default="0")
     */
    private $key;

    /**
     *
     * @var int $pId 商品父级【编号】
     *      @Column(name="p_id", type="integer", default=0)
     */
    private $pId;

    /**
     *
     * @var string $sku SKU
     *      @Column(name="sku", type="string", length=128, default="")
     */
    private $sku;

    /**
     * 商品条形码
     * 
     * @param string $value            
     * @return $this
     */
    public function setBarCode(string $value): self
    {
        $this->barCode = $value;
        
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
     * 规格键名
     * 
     * @param string $value            
     * @return $this
     */
    public function setKey(string $value): self
    {
        $this->key = $value;
        
        return $this;
    }

    /**
     * 商品父级【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPId(int $value): self
    {
        $this->pId = $value;
        
        return $this;
    }

    /**
     * SKU
     * 
     * @param string $value            
     * @return $this
     */
    public function setSku(string $value): self
    {
        $this->sku = $value;
        
        return $this;
    }

    /**
     * 商品条形码
     * 
     * @return string
     */
    public function getBarCode()
    {
        return $this->barCode;
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
     * 规格键名
     * 
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 商品父级【编号】
     * 
     * @return int
     */
    public function getPId()
    {
        return $this->pId;
    }

    /**
     * SKU
     * 
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }
}
