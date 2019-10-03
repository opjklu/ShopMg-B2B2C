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
 * 密保问题表
 *
 * @Entity()
 * @Table(name="mg_security_question")
 * 
 * @uses DbSecurityQuestion
 */
class DbSecurityQuestion extends Model
{

    /**
     *
     * @var int $addTime 添加时间
     *      @Column(name="add_time", type="integer")
     *      @Required()
     */
    private $addTime;

    /**
     *
     * @var string $answer 答案
     *      @Column(name="answer", type="string", length=50)
     *      @Required()
     */
    private $answer;

    /**
     *
     * @var int $id 主键id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $problem 问题
     *      @Column(name="problem", type="string", length=50)
     *      @Required()
     */
    private $problem;

    /**
     *
     * @var int $updateTime 修改时间
     *      @Column(name="update_time", type="integer")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 添加时间
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
     * 答案
     * 
     * @param string $value            
     * @return $this
     */
    public function setAnswer(string $value): self
    {
        $this->answer = $value;
        
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
     * 问题
     * 
     * @param string $value            
     * @return $this
     */
    public function setProblem(string $value): self
    {
        $this->problem = $value;
        
        return $this;
    }

    /**
     * 修改时间
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
     * 用户id
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
     * 添加时间
     * 
     * @return int
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * 答案
     * 
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
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
     * 问题
     * 
     * @return string
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * 修改时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 用户id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
