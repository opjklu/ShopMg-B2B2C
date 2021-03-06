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
 * @Entity()
 * @Table(name="mg_service_type")
 * 
 * @uses DbServiceType
 */
class DbServiceType extends Model
{

    /**
     *
     * @var string $account 客服工具
     *      @Column(name="account", type="string", length=50)
     *      @Required()
     */
    private $account;

    /**
     *
     * @var int $id 主键id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $name 客户类型名称
     *      @Column(name="name", type="string", length=30)
     *      @Required()
     */
    private $name;

    /**
     *
     * @var int $servicetypeId 客服类型id
     *      @Column(name="servicetype_id", type="integer")
     *      @Required()
     */
    private $servicetypeId;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="smallint", default=50)
     */
    private $sort;

    /**
     *
     * @var int $status 是否启用 0不启用 1启用
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺id
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     * 客服工具
     * 
     * @param string $value            
     * @return $this
     */
    public function setAccount(string $value): self
    {
        $this->account = $value;
        
        return $this;
    }

    /**
     * 主键id
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
     * 客户类型名称
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
     * 客服类型id
     * 
     * @param int $value            
     * @return $this
     */
    public function setServicetypeId(int $value): self
    {
        $this->servicetypeId = $value;
        
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
     * 是否启用 0不启用 1启用
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
     * 店铺id
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreId(int $value): self
    {
        $this->storeId = $value;
        
        return $this;
    }

    /**
     * 客服工具
     * 
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * 主键id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 客户类型名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 客服类型id
     * 
     * @return int
     */
    public function getServicetypeId()
    {
        return $this->servicetypeId;
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
     * 是否启用 0不启用 1启用
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺id
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
