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
 * 文章内容
 *
 * @Entity()
 * @Table(name="mg_article_content")
 * 
 * @uses DbArticleContent
 */
class DbArticleContent extends Model
{

    /**
     *
     * @var int $articleId 文章【编号】
     *      @Column(name="article_id", type="integer")
     *      @Required()
     */
    private $articleId;

    /**
     *
     * @var string $content 文章内容
     *      @Column(name="content", type="text", length=65535)
     */
    private $content;

    /**
     *
     * @var int $id 文章【编号】
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     * 文章【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setArticleId(int $value): self
    {
        $this->articleId = $value;
        
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
     * 文章【编号】
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
     * 文章【编号】
     * 
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
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
     * 文章【编号】
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
