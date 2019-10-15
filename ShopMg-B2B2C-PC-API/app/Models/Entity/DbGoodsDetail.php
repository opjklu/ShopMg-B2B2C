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
 * 商品详情表
 *
 * @Entity()
 * @Table(name="mg_goods_detail")
 * 
 * @uses DbGoodsDetail
 */
class DbGoodsDetail extends Model
{

    /**
     *
     * @var string $detail 详情
     *      @Column(name="detail", type="text", length=65535)
     */
    private $detail;

    /**
     *
     * @var int $goodsId 商品编号
     *      @Column(name="goods_id", type="integer", default=0)
     */
    private $goodsId;

    /**
     *
     * @var int $id 主键编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $updateTime 更新时间【标记更新】
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     * 详情
     * 
     * @param string $value            
     * @return $this
     */
    public function setDetail(string $value): self
    {
        $this->detail = $value;
        
        return $this;
    }

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
     * 主键编号
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
     * 更新时间【标记更新】
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
     * 详情
     * 
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
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
     * 主键编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 更新时间【标记更新】
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
