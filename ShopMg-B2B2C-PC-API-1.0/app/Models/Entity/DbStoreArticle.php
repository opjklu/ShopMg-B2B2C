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
 * 店铺文章表
 *
 * @Entity()
 * @Table(name="mg_store_article")
 * 
 * @uses DbStoreArticle
 */
class DbStoreArticle extends Model
{

    /**
     *
     * @var int $categoryId 文章分类编号
     *      @Column(name="category_id", type="integer")
     *      @Required()
     */
    private $categoryId;

    /**
     *
     * @var string $content 文章内容
     *      @Column(name="content", type="text", length=65535)
     *      @Required()
     */
    private $content;

    /**
     *
     * @var int $display 是否显示 1为显示 0为不显示
     *      @Column(name="display", type="integer", default=1)
     */
    private $display;

    /**
     *
     * @var int $id 文章编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $intro 文章摘要
     *      @Column(name="intro", type="text", length=255)
     *      @Required()
     */
    private $intro;

    /**
     *
     * @var string $keyword 关键字
     *      @Column(name="keyword", type="string", length=255)
     *      @Required()
     */
    private $keyword;

    /**
     *
     * @var string $pic 文章缩略图
     *      @Column(name="pic", type="string", length=255)
     *      @Required()
     */
    private $pic;

    /**
     *
     * @var int $recommend 是否推荐 0为不推荐 1为推荐
     *      @Column(name="recommend", type="integer", default=0)
     */
    private $recommend;

    /**
     *
     * @var int $sort 文章排序
     *      @Column(name="sort", type="integer", default=50)
     */
    private $sort;

    /**
     *
     * @var string $source 文章来源
     *      @Column(name="source", type="string", length=255)
     *      @Required()
     */
    private $source;

    /**
     *
     * @var string $title 文章标题
     *      @Column(name="title", type="string", length=255)
     *      @Required()
     */
    private $title;

    /**
     * 文章分类编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setCategoryId(int $value): self
    {
        $this->categoryId = $value;
        
        return $this;
    }

    /**
     * 文章内容
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
     * 是否显示 1为显示 0为不显示
     * 
     * @param int $value            
     * @return $this
     */
    public function setDisplay(int $value): self
    {
        $this->display = $value;
        
        return $this;
    }

    /**
     * 文章编号
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
     * 文章摘要
     * 
     * @param string $value            
     * @return $this
     */
    public function setIntro(string $value): self
    {
        $this->intro = $value;
        
        return $this;
    }

    /**
     * 关键字
     * 
     * @param string $value            
     * @return $this
     */
    public function setKeyword(string $value): self
    {
        $this->keyword = $value;
        
        return $this;
    }

    /**
     * 文章缩略图
     * 
     * @param string $value            
     * @return $this
     */
    public function setPic(string $value): self
    {
        $this->pic = $value;
        
        return $this;
    }

    /**
     * 是否推荐 0为不推荐 1为推荐
     * 
     * @param int $value            
     * @return $this
     */
    public function setRecommend(int $value): self
    {
        $this->recommend = $value;
        
        return $this;
    }

    /**
     * 文章排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setSort(int $value): self
    {
        $this->sort = $value;
        
        return $this;
    }

    /**
     * 文章来源
     * 
     * @param string $value            
     * @return $this
     */
    public function setSource(string $value): self
    {
        $this->source = $value;
        
        return $this;
    }

    /**
     * 文章标题
     * 
     * @param string $value            
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;
        
        return $this;
    }

    /**
     * 文章分类编号
     * 
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * 文章内容
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 是否显示 1为显示 0为不显示
     * 
     * @return mixed
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * 文章编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 文章摘要
     * 
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * 关键字
     * 
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * 文章缩略图
     * 
     * @return string
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * 是否推荐 0为不推荐 1为推荐
     * 
     * @return int
     */
    public function getRecommend()
    {
        return $this->recommend;
    }

    /**
     * 文章排序
     * 
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 文章来源
     * 
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * 文章标题
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
