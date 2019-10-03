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
 * 客服
 *
 * @Entity()
 * @Table(name="mg_service")
 * 
 * @uses DbService
 */
class DbService extends Model
{

    /**
     *
     * @var string $account 客服账号
     *      @Column(name="account", type="string", length=50, default="0")
     */
    private $account;

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isMain 是否主客服 0不是 1是
     *      @Column(name="is_main", type="tinyint", default=0)
     */
    private $isMain;

    /**
     *
     * @var string $name 客服名称
     *      @Column(name="name", type="string", length=30, default="0")
     */
    private $name;

    /**
     *
     * @var int $servicetypeId 客服类型id
     *      @Column(name="servicetype_id", type="integer", default=1)
     */
    private $servicetypeId;

    /**
     *
     * @var int $sort 排序
     *      @Column(name="sort", type="tinyint", default=50)
     */
    private $sort;

    /**
     *
     * @var int $status 是否显示 1为显示 0不显示
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
     *
     * @var string $tool 客服工具
     *      @Column(name="tool", type="string", length=20, default="0")
     */
    private $tool;

    /**
     * 客服账号
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
     * 是否主客服 0不是 1是
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsMain(int $value): self
    {
        $this->isMain = $value;
        
        return $this;
    }

    /**
     * 客服名称
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
     * 是否显示 1为显示 0不显示
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
     * @param string $value            
     * @return $this
     */
    public function setTool(string $value): self
    {
        $this->tool = $value;
        
        return $this;
    }

    /**
     * 客服账号
     * 
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 是否主客服 0不是 1是
     * 
     * @return int
     */
    public function getIsMain()
    {
        return $this->isMain;
    }

    /**
     * 客服名称
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
     * @return mixed
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
     * 是否显示 1为显示 0不显示
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

    /**
     * 客服工具
     * 
     * @return string
     */
    public function getTool()
    {
        return $this->tool;
    }
}
