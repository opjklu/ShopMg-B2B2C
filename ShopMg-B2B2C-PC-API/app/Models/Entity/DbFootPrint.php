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
 * 足迹表
 *
 * @Entity()
 * @Table(name="mg_foot_print")
 * 
 * @uses DbFootPrint
 */
class DbFootPrint extends Model
{

    /**
     *
     * @var int $createTime 时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $gid 商品id
     *      @Column(name="gid", type="integer")
     */
    private $gid;

    /**
     *
     * @var int $id 足迹表
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $uid 用户id
     *      @Column(name="uid", type="integer")
     */
    private $uid;

    /**
     * 时间
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
    public function setGid(int $value): self
    {
        $this->gid = $value;
        
        return $this;
    }

    /**
     * 足迹表
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
     * 用户id
     * 
     * @param int $value            
     * @return $this
     */
    public function setUid(int $value): self
    {
        $this->uid = $value;
        
        return $this;
    }

    /**
     * 时间
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
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * 足迹表
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 用户id
     * 
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }
}
