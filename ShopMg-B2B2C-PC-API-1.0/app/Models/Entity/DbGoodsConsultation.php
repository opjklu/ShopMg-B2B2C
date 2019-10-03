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
 * 商品咨询表
 *
 * @Entity()
 * @Table(name="mg_goods_consultation")
 * 
 * @uses DbGoodsConsultation
 */
class DbGoodsConsultation extends Model
{

    /**
     *
     * @var int $commentType 0 商品咨询 1支付咨询 2 配送 3 售后
     *      @Column(name="comment_type", type="tinyint", default=0)
     */
    private $commentType;

    /**
     *
     * @var string $content 咨询内容
     *      @Column(name="content", type="string", length=512, default="")
     */
    private $content;

    /**
     *
     * @var int $createTime 咨询时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $goodsId 商品名称编号
     *      @Column(name="goods_id", type="integer", default=0)
     */
    private $goodsId;

    /**
     *
     * @var int $id 商品咨询id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $ip ip地址
     *      @Column(name="ip", type="string", length=30)
     */
    private $ip;

    /**
     *
     * @var int $isShow 是否显示 0不显示 1 显示
     *      @Column(name="is_show", type="tinyint", default=1)
     */
    private $isShow;

    /**
     *
     * @var int $userId 用户名编号
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     * 0 商品咨询 1支付咨询 2 配送 3 售后
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
     * 咨询内容
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
     * 咨询时间
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
     * 商品名称编号
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
     * 商品咨询id
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
     * ip地址
     * 
     * @param string $value            
     * @return $this
     */
    public function setIp(string $value): self
    {
        $this->ip = $value;
        
        return $this;
    }

    /**
     * 是否显示 0不显示 1 显示
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsShow(int $value): self
    {
        $this->isShow = $value;
        
        return $this;
    }

    /**
     * 用户名编号
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
     * 0 商品咨询 1支付咨询 2 配送 3 售后
     * 
     * @return int
     */
    public function getCommentType()
    {
        return $this->commentType;
    }

    /**
     * 咨询内容
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 咨询时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 商品名称编号
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 商品咨询id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * ip地址
     * 
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * 是否显示 0不显示 1 显示
     * 
     * @return mixed
     */
    public function getIsShow()
    {
        return $this->isShow;
    }

    /**
     * 用户名编号
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
