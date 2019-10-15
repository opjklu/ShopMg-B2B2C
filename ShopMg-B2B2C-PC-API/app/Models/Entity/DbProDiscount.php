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
 * 促销策略表
 *
 * @Entity()
 * @Table(name="mg_pro_discount")
 * 
 * @uses DbProDiscount
 */
class DbProDiscount extends Model
{

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var float $proDiscount 促销策略
     *      @Column(name="pro_discount", type="decimal", default=0)
     */
    private $proDiscount;

    /**
     *
     * @var int $proId 促销类型编号
     *      @Column(name="pro_id", type="integer", default=0)
     */
    private $proId;

    /**
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
     * 促销策略
     * 
     * @param float $value            
     * @return $this
     */
    public function setProDiscount(float $value): self
    {
        $this->proDiscount = $value;
        
        return $this;
    }

    /**
     * 促销类型编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setProId(int $value): self
    {
        $this->proId = $value;
        
        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 促销策略
     * 
     * @return mixed
     */
    public function getProDiscount()
    {
        return $this->proDiscount;
    }

    /**
     * 促销类型编号
     * 
     * @return int
     */
    public function getProId()
    {
        return $this->proId;
    }
}
