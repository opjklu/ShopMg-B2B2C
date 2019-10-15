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
 * 消息表
 *
 * @Entity()
 * @Table(name="mg_news")
 * 
 * @uses DbNews
 */
class DbNews extends Model
{

    /**
     *
     * @var int $createTime 时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $id 消息表
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $newsInfo 消息详情
     *      @Column(name="news_info", type="text", length=65535)
     */
    private $newsInfo;

    /**
     *
     * @var string $theme 消息主题
     *      @Column(name="theme", type="string", length=225)
     */
    private $theme;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="smallint")
     */
    private $userId;

    /**
     * 时间
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
     * 消息表
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
     * 消息详情
     * 
     * @param string $value            
     * @return $this
     */
    public function setNewsInfo(string $value): self
    {
        $this->newsInfo = $value;
        
        return $this;
    }

    /**
     * 消息主题
     * 
     * @param string $value            
     * @return $this
     */
    public function setTheme(string $value): self
    {
        $this->theme = $value;
        
        return $this;
    }

    /**
     * 用户id
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
     * 时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 消息表
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 消息详情
     * 
     * @return string
     */
    public function getNewsInfo()
    {
        return $this->newsInfo;
    }

    /**
     * 消息主题
     * 
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * 用户id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
