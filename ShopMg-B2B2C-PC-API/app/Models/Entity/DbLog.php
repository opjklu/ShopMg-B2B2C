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
 * 日志主表
 *
 * @Entity()
 * @Table(name="mg_log")
 * 
 * @uses DbLog
 */
class DbLog extends Model
{

    /**
     *
     * @var int $adminId 管理员id
     *      @Column(name="admin_id", type="bigint")
     */
    private $adminId;

    /**
     *
     * @var string $comment 表注释
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
     * @var int $id 日志id编号
     *      @Id()
     *      @Column(name="id", type="bigint")
     */
    private $id;

    /**
     *
     * @var string $ip IP地址
     *      @Column(name="ip", type="string", length=30)
     */
    private $ip;

    /**
     *
     * @var int $tableId 操作的数据行
     *      @Column(name="table_id", type="bigint")
     */
    private $tableId;

    /**
     *
     * @var string $tableName 表名
     *      @Column(name="table_name", type="string", length=255)
     */
    private $tableName;

    /**
     *
     * @var int $type 操作类型【0新增1修改2删除】
     *      @Column(name="type", type="tinyint", default=1)
     */
    private $type;

    /**
     * 管理员id
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
     * 表注释
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
     * 日志id编号
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
     * IP地址
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
     * 操作的数据行
     * 
     * @param int $value            
     * @return $this
     */
    public function setTableId(int $value): self
    {
        $this->tableId = $value;
        
        return $this;
    }

    /**
     * 表名
     * 
     * @param string $value            
     * @return $this
     */
    public function setTableName(string $value): self
    {
        $this->tableName = $value;
        
        return $this;
    }

    /**
     * 操作类型【0新增1修改2删除】
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
     * 管理员id
     * 
     * @return int
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * 表注释
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
     * 日志id编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * IP地址
     * 
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * 操作的数据行
     * 
     * @return int
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * 表名
     * 
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * 操作类型【0新增1修改2删除】
     * 
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}
