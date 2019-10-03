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
 * 促销类型表
 *
 * @Entity()
 * @Table(name="mg_promotion_type")
 * 
 * @uses DbPromotionType
 */
class DbPromotionType extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $promationName 促销类型
     *      @Column(name="promation_name", type="string", length=30, default="")
     */
    private $promationName;

    /**
     *
     * @var int $status 0 打折，1,减价优惠,2,固定金额出售3,赠品
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

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
     * 促销类型
     * 
     * @param string $value            
     * @return $this
     */
    public function setPromationName(string $value): self
    {
        $this->promationName = $value;
        
        return $this;
    }

    /**
     * 0 打折，1,减价优惠,2,固定金额出售3,赠品
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
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
     * 促销类型
     * 
     * @return string
     */
    public function getPromationName()
    {
        return $this->promationName;
    }

    /**
     * 0 打折，1,减价优惠,2,固定金额出售3,赠品
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
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
