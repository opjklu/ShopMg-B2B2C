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
 * 文章
 *
 * @Entity()
 * @Table(name="mg_article")
 * 
 * @uses DbArticle
 */
class DbArticle extends Model
{

    /**
     *
     * @var int $adminId 管理员名字
     *      @Column(name="admin_id", type="integer")
     */
    private $adminId;

    /**
     *
     * @var int $articleCategoryId 文章分类id
     *      @Column(name="article_category_id", type="tinyint", default=0)
     */
    private $articleCategoryId;

    /**
     *
     * @var int $createTime 录入时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id 文章ID
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $intro 文章详情
     *      @Column(name="intro", type="string", length=128, default="")
     */
    private $intro;

    /**
     *
     * @var string $name 文章标题
     *      @Column(name="name", type="string", length=50, default="")
     */
    private $name;

    /**
     *
     * @var string $picUrl 图片
     *      @Column(name="pic_url", type="string", length=255)
     */
    private $picUrl;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="tinyint", default=20)
     */
    private $sort;

    /**
     *
     * @var int $status 显示状态
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     * 管理员名字
     * 
     * @param int $value            
     * @return $this
     */
    public function setAdminId(int $value): self
    {
        $this->adminId = $value;
        
        return $this;
    }

    /**
     * 文章分类id
     * 
     * @param int $value            
     * @return $this
     */
    public function setArticleCategoryId(int $value): self
    {
        $this->articleCategoryId = $value;
        
        return $this;
    }

    /**
     * 录入时间
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
     * 文章ID
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
     * 文章详情
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
     * 文章标题
     * 
     * @param string $value            
     * @return $this
     */
    public function setName(string $value): self
    {
        $this->name = $value;
        
        return $this;
    }

    /**
     * 图片
     * 
     * @param string $value            
     * @return $this
     */
    public function setPicUrl(string $value): self
    {
        $this->picUrl = $value;
        
        return $this;
    }

    /**
     * 排序
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
     * 显示状态
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
     * 管理员名字
     * 
     * @return int
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * 文章分类id
     * 
     * @return int
     */
    public function getArticleCategoryId()
    {
        return $this->articleCategoryId;
    }

    /**
     * 录入时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 文章ID
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 文章详情
     * 
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * 文章标题
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 图片
     * 
     * @return string
     */
    public function getPicUrl()
    {
        return $this->picUrl;
    }

    /**
     * 排序
     * 
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 显示状态
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
