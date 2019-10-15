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
 * 用户数据表
 *
 * @Entity()
 * @Table(name="mg_user_data")
 * 
 * @uses DbUserData
 */
class DbUserData extends Model
{

    /**
     *
     * @var int $alreadyIntegral 已使用积分
     *      @Column(name="already_integral", type="integer", default=0)
     */
    private $alreadyIntegral;

    /**
     *
     * @var int $beOverdue 过期积分
     *      @Column(name="be_overdue", type="integer", default=0)
     */
    private $beOverdue;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $currentIntegral 当前积分
     *      @Column(name="current_integral", type="integer")
     *      @Required()
     */
    private $currentIntegral;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户编号
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 已使用积分
     * 
     * @param int $value            
     * @return $this
     */
    public function setAlreadyIntegral(int $value): self
    {
        $this->alreadyIntegral = $value;
        
        return $this;
    }

    /**
     * 过期积分
     * 
     * @param int $value            
     * @return $this
     */
    public function setBeOverdue(int $value): self
    {
        $this->beOverdue = $value;
        
        return $this;
    }

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
     * 当前积分
     * 
     * @param int $value            
     * @return $this
     */
    public function setCurrentIntegral(int $value): self
    {
        $this->currentIntegral = $value;
        
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
     * 用户编号
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
     * 已使用积分
     * 
     * @return int
     */
    public function getAlreadyIntegral()
    {
        return $this->alreadyIntegral;
    }

    /**
     * 过期积分
     * 
     * @return int
     */
    public function getBeOverdue()
    {
        return $this->beOverdue;
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
     * 当前积分
     * 
     * @return int
     */
    public function getCurrentIntegral()
    {
        return $this->currentIntegral;
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
     * 更新时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 用户编号
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
