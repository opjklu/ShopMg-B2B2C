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
 * 套餐订单评论图片表
 *
 * @Entity()
 * @Table(name="mg_order_package_comment_img")
 * 
 * @uses DbOrderPackageCommentImg
 */
class DbOrderPackageCommentImg extends Model
{

    /**
     *
     * @var int $commentId 评论路径
     *      @Column(name="comment_id", type="integer")
     *      @Required()
     */
    private $commentId;

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $path 图片路径
     *      @Column(name="path", type="string", length=50)
     *      @Required()
     */
    private $path;

    /**
     * 评论路径
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
     * 图片路径
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
     * 评论路径
     * 
     * @return int
     */
    public function getCommentId()
    {
        return $this->commentId;
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
     * 图片路径
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
