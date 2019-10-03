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
 * 店铺导航表
 *
 * @Entity()
 * @Table(name="mg_store_nav")
 * 
 * @uses DbStoreNav
 */
class DbStoreNav extends Model
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
     * @var int $isShow 是否显示,0-不显示,1-显示
     *      @Column(name="is_show", type="tinyint", default=1)
     */
    private $isShow;

    /**
     *
     * @var string $name 导航名称
     *      @Column(name="name", type="string", length=20, default="")
     */
    private $name;

    /**
     *
     * @var int $orderBy 排序
     *      @Column(name="order_by", type="integer", default=10)
     */
    private $orderBy;

    /**
     *
     * @var int $storeId 店铺id
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     *
     * @var string $url 链接地址
     *      @Column(name="url", type="string", length=255, default="")
     */
    private $url;

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
     * 是否显示,0-不显示,1-显示
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsShow(int $value): self
    {
        $this->isShow = $value;
        
        return $this;
    }

    /**
     * 导航名称
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
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderBy(int $value): self
    {
        $this->orderBy = $value;
        
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
     * 链接地址
     * 
     * @param string $value            
     * @return $this
     */
    public function setUrl(string $value): self
    {
        $this->url = $value;
        
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
     * 是否显示,0-不显示,1-显示
     * 
     * @return mixed
     */
    public function getIsShow()
    {
        return $this->isShow;
    }

    /**
     * 导航名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 排序
     * 
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
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
     * 链接地址
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
