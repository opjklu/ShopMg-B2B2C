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
 * 套餐商品表
 *
 * @Entity()
 * @Table(name="mg_goods_package_sub")
 * 
 * @uses DbGoodsPackageSub
 */
class DbGoodsPackageSub extends Model
{

    /**
     *
     * @var float $discount 商品套餐价
     *      @Column(name="discount", type="decimal")
     */
    private $discount;

    /**
     *
     * @var int $goodsId 商品【id】
     *      @Column(name="goods_id", type="integer")
     *      @Required()
     */
    private $goodsId;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $packageId 套餐【id】
     *      @Column(name="package_id", type="integer")
     *      @Required()
     */
    private $packageId;

    /**
     * 商品套餐价
     * 
     * @param float $value            
     * @return $this
     */
    public function setDiscount(float $value): self
    {
        $this->discount = $value;
        
        return $this;
    }

    /**
     * 商品【id】
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
     * 编号
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
     * 套餐【id】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPackageId(int $value): self
    {
        $this->packageId = $value;
        
        return $this;
    }

    /**
     * 商品套餐价
     * 
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * 商品【id】
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 套餐【id】
     * 
     * @return int
     */
    public function getPackageId()
    {
        return $this->packageId;
    }
}
