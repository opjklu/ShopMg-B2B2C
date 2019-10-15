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
 * 物以群分，人以类聚
 *
 * @Entity()
 * @Table(name="mg_user_level")
 * 
 * @uses DbUserLevel
 */
class DbUserLevel extends Model
{

    /**
     *
     * @var string $description 等级描述
     *      @Column(name="description", type="string", length=100)
     */
    private $description;

    /**
     *
     * @var float $discountRate 折扣率
     *      @Column(name="discount_rate", type="decimal", default=100)
     */
    private $discountRate;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $integralBig 积分上限
     *      @Column(name="integral_big", type="integer")
     */
    private $integralBig;

    /**
     *
     * @var int $integralSmall 积分下限
     *      @Column(name="integral_small", type="integer")
     */
    private $integralSmall;

    /**
     *
     * @var string $levelName 等级名称
     *      @Column(name="level_name", type="string", length=20)
     */
    private $levelName;

    /**
     *
     * @var int $status 会员等级状态 1 使用 0弃用
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     * 等级描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setDescription(string $value): self
    {
        $this->description = $value;
        
        return $this;
    }

    /**
     * 折扣率
     * 
     * @param float $value            
     * @return $this
     */
    public function setDiscountRate(float $value): self
    {
        $this->discountRate = $value;
        
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
     * 积分上限
     * 
     * @param int $value            
     * @return $this
     */
    public function setIntegralBig(int $value): self
    {
        $this->integralBig = $value;
        
        return $this;
    }

    /**
     * 积分下限
     * 
     * @param int $value            
     * @return $this
     */
    public function setIntegralSmall(int $value): self
    {
        $this->integralSmall = $value;
        
        return $this;
    }

    /**
     * 等级名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setLevelName(string $value): self
    {
        $this->levelName = $value;
        
        return $this;
    }

    /**
     * 会员等级状态 1 使用 0弃用
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
     * 等级描述
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 折扣率
     * 
     * @return mixed
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
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
     * 积分上限
     * 
     * @return int
     */
    public function getIntegralBig()
    {
        return $this->integralBig;
    }

    /**
     * 积分下限
     * 
     * @return int
     */
    public function getIntegralSmall()
    {
        return $this->integralSmall;
    }

    /**
     * 等级名称
     * 
     * @return string
     */
    public function getLevelName()
    {
        return $this->levelName;
    }

    /**
     * 会员等级状态 1 使用 0弃用
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
