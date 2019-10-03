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
 * 合作伙伴
 *
 * @Entity()
 * @Table(name="mg_cooperative_partner")
 * 
 * @uses DbCooperativePartner
 */
class DbCooperativePartner extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $id 合作伙伴id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 合作伙伴名称
     *      @Column(name="name", type="string", length=255, default="50")
     */
    private $name;

    /**
     *
     * @var string $picUrl 合作伙伴图片
     *      @Column(name="pic_url", type="string", length=255)
     *      @Required()
     */
    private $picUrl;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="tinyint", default=50)
     */
    private $sort;

    /**
     *
     * @var int $status 是否启用 0否 1 是
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

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
     * 合作伙伴id
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
     * 合作伙伴名称
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
     * 合作伙伴图片
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
     * 是否启用 0否 1 是
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 合作伙伴id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 合作伙伴名称
     * 
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 合作伙伴图片
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
     * 是否启用 0否 1 是
     * 
     * @return mixed
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
