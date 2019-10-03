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
 * 套餐订单评论表
 *
 * @Entity()
 * @Table(name="mg_order_package_comment")
 * 
 * @uses DbOrderPackageComment
 */
class DbOrderPackageComment extends Model
{

    /**
     *
     * @var int $anonymous 是否匿名【 0.是 1.否】
     *      @Column(name="anonymous", type="tinyint", default=0)
     */
    private $anonymous;

    /**
     *
     * @var string $anwser 评论回复
     *      @Column(name="anwser", type="string", length=255, default="0")
     */
    private $anwser;

    /**
     *
     * @var string $content 评论内容
     *      @Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     *
     * @var int $createTime 评论时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $goodsId 商品【编号】
     *      @Column(name="goods_id", type="integer")
     *      @Required()
     */
    private $goodsId;

    /**
     *
     * @var int $havePic 是否有图片[0没有,1有]
     *      @Column(name="have_pic", type="tinyint", default=0)
     */
    private $havePic;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $labels 评论标签【0 手感好, 1 发货快 2 物美价廉 3 性价比高】
     *      @Column(name="labels", type="string", length=100)
     */
    private $labels;

    /**
     *
     * @var int $level 评级【 0.差评(1,2分) 1.一般(3,4分) 2.好评(5分)】
     *      @Column(name="level", type="tinyint", default=0)
     */
    private $level;

    /**
     *
     * @var int $orderId 订单【编号】
     *      @Column(name="order_id", type="integer")
     */
    private $orderId;

    /**
     *
     * @var int $score 评分【 1-5】
     *      @Column(name="score", type="tinyint", default=0)
     */
    private $score;

    /**
     *
     * @var int $status 是否可见【1可见, 0.不可见】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $userId 用户【编号】
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 是否匿名【 0.是 1.否】
     * 
     * @param int $value            
     * @return $this
     */
    public function setAnonymous(int $value): self
    {
        $this->anonymous = $value;
        
        return $this;
    }

    /**
     * 评论回复
     * 
     * @param string $value            
     * @return $this
     */
    public function setAnwser(string $value): self
    {
        $this->anwser = $value;
        
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
     * 评论时间
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
     * 商品【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsId(int $value): self
    {
        $this->goodsId = $value;
        
        return $this;
    }

    /**
     * 是否有图片[0没有,1有]
     * 
     * @param int $value            
     * @return $this
     */
    public function setHavePic(int $value): self
    {
        $this->havePic = $value;
        
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
     * 评论标签【0 手感好, 1 发货快 2 物美价廉 3 性价比高】
     * 
     * @param string $value            
     * @return $this
     */
    public function setLabels(string $value): self
    {
        $this->labels = $value;
        
        return $this;
    }

    /**
     * 评级【 0.差评(1,2分) 1.一般(3,4分) 2.好评(5分)】
     * 
     * @param int $value            
     * @return $this
     */
    public function setLevel(int $value): self
    {
        $this->level = $value;
        
        return $this;
    }

    /**
     * 订单【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderId(int $value): self
    {
        $this->orderId = $value;
        
        return $this;
    }

    /**
     * 评分【 1-5】
     * 
     * @param int $value            
     * @return $this
     */
    public function setScore(int $value): self
    {
        $this->score = $value;
        
        return $this;
    }

    /**
     * 是否可见【1可见, 0.不可见】
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
     * 店铺【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreId(int $value): self
    {
        $this->storeId = $value;
        
        return $this;
    }

    /**
     * 用户【编号】
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
     * 是否匿名【 0.是 1.否】
     * 
     * @return int
     */
    public function getAnonymous()
    {
        return $this->anonymous;
    }

    /**
     * 评论回复
     * 
     * @return string
     */
    public function getAnwser()
    {
        return $this->anwser;
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
     * 评论时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 商品【编号】
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 是否有图片[0没有,1有]
     * 
     * @return int
     */
    public function getHavePic()
    {
        return $this->havePic;
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
     * 评论标签【0 手感好, 1 发货快 2 物美价廉 3 性价比高】
     * 
     * @return string
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * 评级【 0.差评(1,2分) 1.一般(3,4分) 2.好评(5分)】
     * 
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * 订单【编号】
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 评分【 1-5】
     * 
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * 是否可见【1可见, 0.不可见】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺【编号】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 用户【编号】
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
