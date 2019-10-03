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
 * 店铺经营类目表
 *
 * @Entity()
 * @Table(name="mg_store_management_category")
 * 
 * @uses DbStoreManagementCategory
 */
class DbStoreManagementCategory extends Model
{

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $oneClass 一级类目
     *      @Column(name="one_class", type="integer", default=0)
     */
    private $oneClass;

    /**
     *
     * @var int $status 入驻类型 0公司入驻 1 企业入驻
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 入驻表编号
     *      @Column(name="store_id", type="integer", default=0)
     */
    private $storeId;

    /**
     *
     * @var int $threeClass 三级类目
     *      @Column(name="three_class", type="integer", default=0)
     */
    private $threeClass;

    /**
     *
     * @var int $twoClass 二级类目
     *      @Column(name="two_class", type="integer", default=0)
     */
    private $twoClass;

    /**
     * 编号
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
     * 一级类目
     * 
     * @param int $value            
     * @return $this
     */
    public function setOneClass(int $value): self
    {
        $this->oneClass = $value;
        
        return $this;
    }

    /**
     * 入驻类型 0公司入驻 1 企业入驻
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
     * 入驻表编号
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
     * 三级类目
     * 
     * @param int $value            
     * @return $this
     */
    public function setThreeClass(int $value): self
    {
        $this->threeClass = $value;
        
        return $this;
    }

    /**
     * 二级类目
     * 
     * @param int $value            
     * @return $this
     */
    public function setTwoClass(int $value): self
    {
        $this->twoClass = $value;
        
        return $this;
    }

    /**
     * 编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 一级类目
     * 
     * @return int
     */
    public function getOneClass()
    {
        return $this->oneClass;
    }

    /**
     * 入驻类型 0公司入驻 1 企业入驻
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 入驻表编号
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 三级类目
     * 
     * @return int
     */
    public function getThreeClass()
    {
        return $this->threeClass;
    }

    /**
     * 二级类目
     * 
     * @return int
     */
    public function getTwoClass()
    {
        return $this->twoClass;
    }
}
