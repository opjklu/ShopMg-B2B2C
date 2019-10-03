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
 * 咨询回复表
 *
 * @Entity()
 * @Table(name="mg_goods_advisory_reply")
 * 
 * @uses DbGoodsAdvisoryReply
 */
class DbGoodsAdvisoryReply extends Model
{

    /**
     *
     * @var int $consultationId 咨询编号d
     *      @Column(name="consultation_id", type="integer")
     *      @Required()
     */
    private $consultationId;

    /**
     *
     * @var string $content 回复内容
     *      @Column(name="content", type="string", length=355)
     *      @Required()
     */
    private $content;

    /**
     *
     * @var int $createTime 回复时间
     *      @Column(name="create_time", type="integer")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $id 主键id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $status 状态 0 隐藏 1 显示
     *      @Column(name="status", type="tinyint")
     *      @Required()
     */
    private $status;

    /**
     *
     * @var int $type 回答类型 【0买家回答 1商户回答】
     *      @Column(name="type", type="tinyint")
     *      @Required()
     */
    private $type;

    /**
     *
     * @var int $userId 回复人id
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 咨询编号d
     * 
     * @param int $value            
     * @return $this
     */
    public function setConsultationId(int $value): self
    {
        $this->consultationId = $value;
        
        return $this;
    }

    /**
     * 回复内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setContent(string $value): self
    {
        $this->content = $value;
        
        return $this;
    }

    /**
     * 回复时间
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
     * 状态 0 隐藏 1 显示
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
     * 回答类型 【0买家回答 1商户回答】
     * 
     * @param int $value            
     * @return $this
     */
    public function setType(int $value): self
    {
        $this->type = $value;
        
        return $this;
    }

    /**
     * 回复人id
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
     * 咨询编号d
     * 
     * @return int
     */
    public function getConsultationId()
    {
        return $this->consultationId;
    }

    /**
     * 回复内容
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 回复时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
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
     * 状态 0 隐藏 1 显示
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 回答类型 【0买家回答 1商户回答】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 回复人id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
