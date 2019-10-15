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
 * 收藏表
 *
 * @Entity()
 * @Table(name="mg_collection")
 * 
 * @uses DbCollection
 */
class DbCollection extends Model
{

    /**
     *
     * @var int $addTime 收藏时间
     *      @Column(name="add_time", type="integer")
     *      @Required()
     */
    private $addTime;

    /**
     *
     * @var int $goodsId 收藏的商品id
     *      @Column(name="goods_id", type="integer")
     *      @Required()
     */
    private $goodsId;

    /**
     *
     * @var int $id 主键id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $status 0普通商品1降价商品
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $userId 收藏者id
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 收藏时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setAddTime(int $value): self
    {
        $this->addTime = $value;
        
        return $this;
    }

    /**
     * 收藏的商品id
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
     * 主键id
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
     * 0普通商品1降价商品
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
     * 收藏者id
     * 
     * @param int $value            
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->userId = $value;
        
        return $this;
    }

    /**
     * 收藏时间
     * 
     * @return int
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * 收藏的商品id
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 主键id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 0普通商品1降价商品
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 收藏者id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
