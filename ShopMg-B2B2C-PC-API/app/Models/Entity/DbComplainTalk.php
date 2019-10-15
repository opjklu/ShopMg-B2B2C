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
 * 投诉对话表
 *
 * @Entity()
 * @Table(name="mg_complain_talk")
 * 
 * @uses DbComplainTalk
 */
class DbComplainTalk extends Model
{

    /**
     *
     * @var int $complainId 投诉id
     *      @Column(name="complain_id", type="integer")
     *      @Required()
     */
    private $complainId;

    /**
     *
     * @var int $talkAdmin 对话管理员，屏蔽对话人的id
     *      @Column(name="talk_admin", type="integer", default=0)
     */
    private $talkAdmin;

    /**
     *
     * @var string $talkContent 发言内容
     *      @Column(name="talk_content", type="string", length=255)
     *      @Required()
     */
    private $talkContent;

    /**
     *
     * @var int $talkDatetime 对话发表时间
     *      @Column(name="talk_datetime", type="integer")
     *      @Required()
     */
    private $talkDatetime;

    /**
     *
     * @var int $talkId 投诉对话id
     *      @Id()
     *      @Column(name="talk_id", type="integer")
     */
    private $talkId;

    /**
     *
     * @var int $talkMemberId 发言人id
     *      @Column(name="talk_member_id", type="integer")
     *      @Required()
     */
    private $talkMemberId;

    /**
     *
     * @var string $talkMemberName 发言人名称
     *      @Column(name="talk_member_name", type="string", length=50)
     *      @Required()
     */
    private $talkMemberName;

    /**
     *
     * @var string $talkMemberType 发言人类型(1-投诉人/2-被投诉人/3-平台)
     *      @Column(name="talk_member_type", type="string", length=10)
     *      @Required()
     */
    private $talkMemberType;

    /**
     *
     * @var int $talkState 发言状态(1-显示/2-不显示)
     *      @Column(name="talk_state", type="tinyint")
     *      @Required()
     */
    private $talkState;

    /**
     * 投诉id
     * 
     * @param int $value            
     * @return $this
     */
    public function setComplainId(int $value): self
    {
        $this->complainId = $value;
        
        return $this;
    }

    /**
     * 对话管理员，屏蔽对话人的id
     * 
     * @param int $value            
     * @return $this
     */
    public function setTalkAdmin(int $value): self
    {
        $this->talkAdmin = $value;
        
        return $this;
    }

    /**
     * 发言内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setTalkContent(string $value): self
    {
        $this->talkContent = $value;
        
        return $this;
    }

    /**
     * 对话发表时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setTalkDatetime(int $value): self
    {
        $this->talkDatetime = $value;
        
        return $this;
    }

    /**
     * 投诉对话id
     * 
     * @param int $value            
     * @return $this
     */
    public function setTalkId(int $value)
    {
        $this->talkId = $value;
        
        return $this;
    }

    /**
     * 发言人id
     * 
     * @param int $value            
     * @return $this
     */
    public function setTalkMemberId(int $value): self
    {
        $this->talkMemberId = $value;
        
        return $this;
    }

    /**
     * 发言人名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setTalkMemberName(string $value): self
    {
        $this->talkMemberName = $value;
        
        return $this;
    }

    /**
     * 发言人类型(1-投诉人/2-被投诉人/3-平台)
     * 
     * @param string $value            
     * @return $this
     */
    public function setTalkMemberType(string $value): self
    {
        $this->talkMemberType = $value;
        
        return $this;
    }

    /**
     * 发言状态(1-显示/2-不显示)
     * 
     * @param int $value            
     * @return $this
     */
    public function setTalkState(int $value): self
    {
        $this->talkState = $value;
        
        return $this;
    }

    /**
     * 投诉id
     * 
     * @return int
     */
    public function getComplainId()
    {
        return $this->complainId;
    }

    /**
     * 对话管理员，屏蔽对话人的id
     * 
     * @return int
     */
    public function getTalkAdmin()
    {
        return $this->talkAdmin;
    }

    /**
     * 发言内容
     * 
     * @return string
     */
    public function getTalkContent()
    {
        return $this->talkContent;
    }

    /**
     * 对话发表时间
     * 
     * @return int
     */
    public function getTalkDatetime()
    {
        return $this->talkDatetime;
    }

    /**
     * 投诉对话id
     * 
     * @return mixed
     */
    public function getTalkId()
    {
        return $this->talkId;
    }

    /**
     * 发言人id
     * 
     * @return int
     */
    public function getTalkMemberId()
    {
        return $this->talkMemberId;
    }

    /**
     * 发言人名称
     * 
     * @return string
     */
    public function getTalkMemberName()
    {
        return $this->talkMemberName;
    }

    /**
     * 发言人类型(1-投诉人/2-被投诉人/3-平台)
     * 
     * @return string
     */
    public function getTalkMemberType()
    {
        return $this->talkMemberType;
    }

    /**
     * 发言状态(1-显示/2-不显示)
     * 
     * @return int
     */
    public function getTalkState()
    {
        return $this->talkState;
    }
}
