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
 * 商户管理中心验证分组
 *
 * @Entity()
 * @Table(name="mg_store_auth_group")
 * 
 * @uses DbStoreAuthGroup
 */
class DbStoreAuthGroup extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var string $explain 角色说明
     *      @Column(name="explain", type="string", length=200, default="0")
     */
    private $explain;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="smallint")
     */
    private $id;

    /**
     *
     * @var string $rules 规则
     *      @Column(name="rules", type="text", length=65535)
     *      @Required()
     */
    private $rules;

    /**
     *
     * @var int $status 显示状态
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var string $title 名称
     *      @Column(name="title", type="char", length=100, default="")
     */
    private $title;

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
     * 角色说明
     * 
     * @param string $value            
     * @return $this
     */
    public function setExplain(string $value): self
    {
        $this->explain = $value;
        
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
     * 规则
     * 
     * @param string $value            
     * @return $this
     */
    public function setRules(string $value): self
    {
        $this->rules = $value;
        
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
     * 名称
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 角色说明
     * 
     * @return string
     */
    public function getExplain()
    {
        return $this->explain;
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
     * 规则
     * 
     * @return string
     */
    public function getRules()
    {
        return $this->rules;
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

    /**
     * 名称
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
