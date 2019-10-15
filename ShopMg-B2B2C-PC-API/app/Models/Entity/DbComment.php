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
 * 评论表
 *
 * @Entity()
 * @Table(name="mg_comment")
 * 
 * @uses DbComment
 */
class DbComment extends Model
{

    /**
     *
     * @var int $commentType 评论分类
     *      @Column(name="comment_type", type="tinyint")
     */
    private $commentType;

    /**
     *
     * @var string $content 评论内容
     *      @Column(name="content", type="string", length=200)
     */
    private $content;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $userId 会员ID
     *      @Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * 评论分类
     * 
     * @param int $value            
     * @return $this
     */
    public function setCommentType(int $value): self
    {
        $this->commentType = $value;
        
        return $this;
    }

    /**
     * 评论内容
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
     * 会员ID
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
     * 评论分类
     * 
     * @return int
     */
    public function getCommentType()
    {
        return $this->commentType;
    }

    /**
     * 评论内容
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
     * id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 会员ID
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
