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
 * 公告表
 *
 * @Entity()
 * @Table(name="mg_announcement")
 * 
 * @uses DbAnnouncement
 */
class DbAnnouncement extends Model
{

    /**
     *
     * @var string $adminAccount 作者
     *      @Column(name="admin_account", type="string", length=50)
     */
    private $adminAccount;

    /**
     *
     * @var string $content 公告内容
     *      @Column(name="content", type="text", length=65535)
     */
    private $content;

    /**
     *
     * @var int $createTime 公告创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $id 公告id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $intro 公告简介
     *      @Column(name="intro", type="string", length=255)
     */
    private $intro;

    /**
     *
     * @var int $sort 排序 默认:50
     *      @Column(name="sort", type="integer")
     */
    private $sort;

    /**
     *
     * @var int $status 显示状态 0不显示 默认：1显示
     *      @Column(name="status", type="integer")
     */
    private $status;

    /**
     *
     * @var string $title 公告标题
     *      @Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     *
     * @var int $type 公告类型 默认：0不选 1新
     *      @Column(name="type", type="integer")
     */
    private $type;

    /**
     *
     * @var int $updateTime 公告最后一次编辑时间
     *      @Column(name="update_time", type="integer")
     */
    private $updateTime;

    /**
     * 作者
     * 
     * @param string $value            
     * @return $this
     */
    public function setAdminAccount(string $value): self
    {
        $this->adminAccount = $value;
        
        return $this;
    }

    /**
     * 公告内容
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
     * 公告创建时间
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
     * 公告id
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
     * 公告简介
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
     * 排序 默认:50
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
     * 显示状态 0不显示 默认：1显示
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
     * 公告标题
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
     * 公告类型 默认：0不选 1新
     * 
     * @param int $value            
     * @return $this
     */
    public function setType(int $value): self
    {
        $this->type = $value;
        
        return $this;
    }

    /**
     * 公告最后一次编辑时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setUpdateTime(int $value): self
    {
        $this->updateTime = $value;
        
        return $this;
    }

    /**
     * 作者
     * 
     * @return string
     */
    public function getAdminAccount()
    {
        return $this->adminAccount;
    }

    /**
     * 公告内容
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 公告创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 公告id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 公告简介
     * 
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * 排序 默认:50
     * 
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 显示状态 0不显示 默认：1显示
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 公告标题
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 公告类型 默认：0不选 1新
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 公告最后一次编辑时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
