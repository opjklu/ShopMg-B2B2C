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
 * 店铺导航背景色表
 *
 * @Entity()
 * @Table(name="mg_store_nav_color")
 * 
 * @uses DbStoreNavColor
 */
class DbStoreNavColor extends Model
{

    /**
     *
     * @var string $color 导航背景色-16进制
     *      @Column(name="color", type="char", length=7)
     *      @Required()
     */
    private $color;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $storeId 店铺id
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     * 导航背景色-16进制
     * 
     * @param string $value            
     * @return $this
     */
    public function setColor(string $value): self
    {
        $this->color = $value;
        
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
     * 店铺id
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
     * 导航背景色-16进制
     * 
     * @return string
     */
    public function getColor()
    {
        return $this->color;
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
     * 店铺id
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
