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
 * 商品活动限购表
 *
 * @Entity()
 * @Table(name="mg_goods_restrictions")
 * 
 * @uses DbGoodsRestrictions
 */
class DbGoodsRestrictions extends Model
{

    /**
     *
     * @var int $goodsId 商品编号
     *      @Column(name="goods_id", type="integer", default=0)
     */
    private $goodsId;

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $restrictionsOver 限购结束时间
     *      @Column(name="restrictions_over", type="string", length=20)
     */
    private $restrictionsOver;

    /**
     *
     * @var string $restrictionsStart 限购开始时间
     *      @Column(name="restrictions_start", type="string", length=20)
     */
    private $restrictionsStart;

    /**
     *
     * @var int $restrictionsStatus 1 已经开启，0未开启
     *      @Column(name="restrictions_status", type="tinyint", default=0)
     */
    private $restrictionsStatus;

    /**
     * 商品编号
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
     * 限购结束时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setRestrictionsOver(string $value): self
    {
        $this->restrictionsOver = $value;
        
        return $this;
    }

    /**
     * 限购开始时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setRestrictionsStart(string $value): self
    {
        $this->restrictionsStart = $value;
        
        return $this;
    }

    /**
     * 1 已经开启，0未开启
     * 
     * @param int $value            
     * @return $this
     */
    public function setRestrictionsStatus(int $value): self
    {
        $this->restrictionsStatus = $value;
        
        return $this;
    }

    /**
     * 商品编号
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
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
     * 限购结束时间
     * 
     * @return string
     */
    public function getRestrictionsOver()
    {
        return $this->restrictionsOver;
    }

    /**
     * 限购开始时间
     * 
     * @return string
     */
    public function getRestrictionsStart()
    {
        return $this->restrictionsStart;
    }

    /**
     * 1 已经开启，0未开启
     * 
     * @return int
     */
    public function getRestrictionsStatus()
    {
        return $this->restrictionsStatus;
    }
}
