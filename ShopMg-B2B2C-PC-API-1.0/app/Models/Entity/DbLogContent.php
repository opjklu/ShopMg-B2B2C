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
 * 日志从表
 *
 * @Entity()
 * @Table(name="mg_log_content")
 * 
 * @uses DbLogContent
 */
class DbLogContent extends Model
{

    /**
     *
     * @var string $comment 字段注释
     *      @Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var string $currentValue 当前值
     *      @Column(name="current_value", type="text", length=65535)
     */
    private $currentValue;

    /**
     *
     * @var int $id 详情id
     *      @Id()
     *      @Column(name="id", type="bigint")
     */
    private $id;

    /**
     *
     * @var string $key 日志键
     *      @Column(name="key", type="string", length=50)
     */
    private $key;

    /**
     *
     * @var int $logId 日志主表编号
     *      @Column(name="log_id", type="bigint")
     */
    private $logId;

    /**
     *
     * @var string $value 以前值
     *      @Column(name="value", type="text", length=65535)
     */
    private $value;

    /**
     * 字段注释
     * 
     * @param string $value            
     * @return $this
     */
    public function setComment(string $value): self
    {
        $this->comment = $value;
        
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
     * 当前值
     * 
     * @param string $value            
     * @return $this
     */
    public function setCurrentValue(string $value): self
    {
        $this->currentValue = $value;
        
        return $this;
    }

    /**
     * 详情id
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
     * 日志键
     * 
     * @param string $value            
     * @return $this
     */
    public function setKey(string $value): self
    {
        $this->key = $value;
        
        return $this;
    }

    /**
     * 日志主表编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setLogId(int $value): self
    {
        $this->logId = $value;
        
        return $this;
    }

    /**
     * 以前值
     * 
     * @param string $value            
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;
        
        return $this;
    }

    /**
     * 字段注释
     * 
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
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
     * 当前值
     * 
     * @return string
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * 详情id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 日志键
     * 
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 日志主表编号
     * 
     * @return int
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * 以前值
     * 
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
