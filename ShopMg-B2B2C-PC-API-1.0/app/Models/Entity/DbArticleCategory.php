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
 * 文章分类
 *
 * @Entity()
 * @Table(name="mg_article_category")
 * 
 * @uses DbArticleCategory
 */
class DbArticleCategory extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $id 分类id
     *      @Id()
     *      @Column(name="id", type="tinyint")
     */
    private $id;

    /**
     *
     * @var string $intro 文章分类详情
     *      @Column(name="intro", type="text", length=65535)
     */
    private $intro;

    /**
     *
     * @var int $isHelp 是否帮助
     *      @Column(name="is_help", type="tinyint", default=1)
     */
    private $isHelp;

    /**
     *
     * @var string $name 文章分类名称
     *      @Column(name="name", type="string", length=50, default="")
     */
    private $name;

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
     * 分类id
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
     * 文章分类详情
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
     * 是否帮助
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsHelp(int $value): self
    {
        $this->isHelp = $value;
        
        return $this;
    }

    /**
     * 文章分类名称
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 分类id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 文章分类详情
     * 
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * 是否帮助
     * 
     * @return mixed
     */
    public function getIsHelp()
    {
        return $this->isHelp;
    }

    /**
     * 文章分类名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
