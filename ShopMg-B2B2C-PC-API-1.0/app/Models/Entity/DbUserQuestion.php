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
 * @Entity()
 * @Table(name="mg_user_question")
 * 
 * @uses DbUserQuestion
 */
class DbUserQuestion extends Model
{

    /**
     *
     * @var string $answer 问题答案
     *      @Column(name="answer", type="string", length=200)
     *      @Required()
     */
    private $answer;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $question 问题
     *      @Column(name="question", type="string", length=200)
     *      @Required()
     */
    private $question;

    /**
     *
     * @var int $serviceId 客服编号
     *      @Column(name="service_id", type="integer")
     *      @Required()
     */
    private $serviceId;

    /**
     *
     * @var int $updateTime @Column(name="update_time", type="bigint")
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
     * 问题答案
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
     * 问题
     * 
     * @param string $value            
     * @return $this
     */
    public function setQuestion(string $value): self
    {
        $this->question = $value;
        
        return $this;
    }

    /**
     * 客服编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setServiceId(int $value): self
    {
        $this->serviceId = $value;
        
        return $this;
    }

    /**
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
     * 问题答案
     * 
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
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
     * 编号
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
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * 客服编号
     * 
     * @return int
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
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
