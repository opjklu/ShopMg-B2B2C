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
 * 规格项
 *
 * @Entity()
 * @Table(name="mg_goods_spec_item")
 * 
 * @uses DbGoodsSpecItem
 */
class DbGoodsSpecItem extends Model
{

    /**
     *
     * @var int $id 规格项id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $item 规格项
     *      @Column(name="item", type="string", length=54)
     */
    private $item;

    /**
     *
     * @var int $specId 规格【id】
     *      @Column(name="spec_id", type="integer")
     */
    private $specId;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     * 规格项id
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
     * 规格项
     * 
     * @param string $value            
     * @return $this
     */
    public function setItem(string $value): self
    {
        $this->item = $value;
        
        return $this;
    }

    /**
     * 规格【id】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSpecId(int $value): self
    {
        $this->specId = $value;
        
        return $this;
    }

    /**
     * 店铺【编号】
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
     * 规格项id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 规格项
     * 
     * @return string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * 规格【id】
     * 
     * @return int
     */
    public function getSpecId()
    {
        return $this->specId;
    }

    /**
     * 店铺【编号】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
