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
 * 商品热词表
 *
 * @Entity()
 * @Table(name="mg_hot_words")
 * 
 * @uses DbHotWords
 */
class DbHotWords extends Model
{

    /**
     *
     * @var string $createTime 创建时间
     *      @Column(name="create_time", type="string", length=20)
     */
    private $createTime;

    /**
     *
     * @var int $goodsClassId 商品分类id
     *      @Column(name="goods_class_id", type="integer")
     */
    private $goodsClassId;

    /**
     *
     * @var string $hotWords 关键词
     *      @Column(name="hot_words", type="string", length=50)
     */
    private $hotWords;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isHide 1为显示，0为隐藏
     *      @Column(name="is_hide", type="tinyint", default=1)
     */
    private $isHide;

    /**
     *
     * @var string $updateTime 更新时间
     *      @Column(name="update_time", type="string", length=20)
     */
    private $updateTime;

    /**
     * 创建时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setCreateTime(string $value): self
    {
        $this->createTime = $value;
        
        return $this;
    }

    /**
     * 商品分类id
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsClassId(int $value): self
    {
        $this->goodsClassId = $value;
        
        return $this;
    }

    /**
     * 关键词
     * 
     * @param string $value            
     * @return $this
     */
    public function setHotWords(string $value): self
    {
        $this->hotWords = $value;
        
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
     * 1为显示，0为隐藏
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsHide(int $value): self
    {
        $this->isHide = $value;
        
        return $this;
    }

    /**
     * 更新时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setUpdateTime(string $value): self
    {
        $this->updateTime = $value;
        
        return $this;
    }

    /**
     * 创建时间
     * 
     * @return string
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 商品分类id
     * 
     * @return int
     */
    public function getGoodsClassId()
    {
        return $this->goodsClassId;
    }

    /**
     * 关键词
     * 
     * @return string
     */
    public function getHotWords()
    {
        return $this->hotWords;
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
     * 1为显示，0为隐藏
     * 
     * @return mixed
     */
    public function getIsHide()
    {
        return $this->isHide;
    }

    /**
     * 更新时间
     * 
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
