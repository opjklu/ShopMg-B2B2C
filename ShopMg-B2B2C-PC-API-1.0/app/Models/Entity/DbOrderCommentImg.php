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
 * 订单评论图片表
 *
 * @Entity()
 * @Table(name="mg_order_comment_img")
 * 
 * @uses DbOrderCommentImg
 */
class DbOrderCommentImg extends Model
{

    /**
     *
     * @var int $commentId 评论【编号】
     *      @Column(name="comment_id", type="integer", default=0)
     */
    private $commentId;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $path 评论图片路径
     *      @Column(name="path", type="string", length=80)
     *      @Required()
     */
    private $path;

    /**
     * 评论【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setCommentId(int $value): self
    {
        $this->commentId = $value;
        
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
     * 评论图片路径
     * 
     * @param string $value            
     * @return $this
     */
    public function setPath(string $value): self
    {
        $this->path = $value;
        
        return $this;
    }

    /**
     * 评论【编号】
     * 
     * @return int
     */
    public function getCommentId()
    {
        return $this->commentId;
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
     * 评论图片路径
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
