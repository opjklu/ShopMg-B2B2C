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
 * 答案表
 *
 * @Entity()
 * @Table(name="mg_answer")
 * 
 * @uses DbAnswer
 */
class DbAnswer extends Model
{

    /**
     *
     * @var int $addtime 回答时间
     *      @Column(name="addtime", type="integer")
     *      @Required()
     */
    private $addtime;

    /**
     *
     * @var string $answer 答案
     *      @Column(name="answer", type="text", length=65535)
     *      @Required()
     */
    private $answer;

    /**
     *
     * @var int $answerCode 回答人编码
     *      @Column(name="answer_code", type="integer")
     *      @Required()
     */
    private $answerCode;

    /**
     *
     * @var int $id 主键id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $problemId 问题id
     *      @Column(name="problem_id", type="integer")
     *      @Required()
     */
    private $problemId;

    /**
     *
     * @var int $status 状态
     *      @Column(name="status", type="tinyint")
     *      @Required()
     */
    private $status;

    /**
     * 回答时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setAddtime(int $value): self
    {
        $this->addtime = $value;
        
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
     * 回答人编码
     * 
     * @param int $value            
     * @return $this
     */
    public function setAnswerCode(int $value): self
    {
        $this->answerCode = $value;
        
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
     * 问题id
     * 
     * @param int $value            
     * @return $this
     */
    public function setProblemId(int $value): self
    {
        $this->problemId = $value;
        
        return $this;
    }

    /**
     * 状态
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
     * 回答时间
     * 
     * @return int
     */
    public function getAddtime()
    {
        return $this->addtime;
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
     * 回答人编码
     * 
     * @return int
     */
    public function getAnswerCode()
    {
        return $this->answerCode;
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
     * 问题id
     * 
     * @return int
     */
    public function getProblemId()
    {
        return $this->problemId;
    }

    /**
     * 状态
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
