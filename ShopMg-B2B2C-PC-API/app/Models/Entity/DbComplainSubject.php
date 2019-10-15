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
 * 投诉主题表
 *
 * @Entity()
 * @Table(name="mg_complain_subject")
 * 
 * @uses DbComplainSubject
 */
class DbComplainSubject extends Model
{

    /**
     *
     * @var string $complainDesc 投诉主题描述
     *      @Column(name="complain_desc", type="string", length=100)
     *      @Required()
     */
    private $complainDesc;

    /**
     *
     * @var string $complainSubject 投诉主题
     *      @Column(name="complain_subject", type="string", length=50)
     *      @Required()
     */
    private $complainSubject;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id 投诉主题id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $status 投诉主题状态【1-有效/0-失效】
     *      @Column(name="status", type="tinyint")
     *      @Required()
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     * 投诉主题描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setComplainDesc(string $value): self
    {
        $this->complainDesc = $value;
        
        return $this;
    }

    /**
     * 投诉主题
     * 
     * @param string $value            
     * @return $this
     */
    public function setComplainSubject(string $value): self
    {
        $this->complainSubject = $value;
        
        return $this;
    }

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
     * 投诉主题id
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
     * 投诉主题状态【1-有效/0-失效】
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
     * 更新时间
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
     * 投诉主题描述
     * 
     * @return string
     */
    public function getComplainDesc()
    {
        return $this->complainDesc;
    }

    /**
     * 投诉主题
     * 
     * @return string
     */
    public function getComplainSubject()
    {
        return $this->complainSubject;
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
     * 投诉主题id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 投诉主题状态【1-有效/0-失效】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 更新时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
