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
 * 导航表
 *
 * @Entity()
 * @Table(name="mg_nav")
 * 
 * @uses DbNav
 */
class DbNav extends Model
{

    /**
     *
     * @var string $createTime 创建时间
     *      @Column(name="create_time", type="string", length=20)
     */
    private $createTime;

    /**
     *
     * @var int $id 导航id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $link 连接地址
     *      @Column(name="link", type="string", length=100)
     */
    private $link;

    /**
     *
     * @var string $navTitile 导航菜单标题
     *      @Column(name="nav_titile", type="string", length=20)
     */
    private $navTitile;

    /**
     *
     * @var string $pic 导航logo
     *      @Column(name="pic", type="string", length=100, default="")
     */
    private $pic;

    /**
     *
     * @var int $platform 平台【0 PC 1 WAP,2 Andriod, 3 IOS， 4微商城 】
     *      @Column(name="platform", type="tinyint", default=0)
     */
    private $platform;

    /**
     *
     * @var int $sort 排序【默认10】
     *      @Column(name="sort", type="integer")
     */
    private $sort;

    /**
     *
     * @var int $status 显示状态【0,不显示 1显示】
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $type 导航类型【0默认 不选 1新】
     *      @Column(name="type", type="integer")
     */
    private $type;

    /**
     *
     * @var string $updateTime 最后一次编辑时间
     *      @Column(name="update_time", type="string", length=20)
     */
    private $updateTime;

    /**
     * 创建时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setCreateTime(string $value): self
    {
        $this->createTime = $value;
        
        return $this;
    }

    /**
     * 导航id
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
     * 连接地址
     * 
     * @param string $value            
     * @return $this
     */
    public function setLink(string $value): self
    {
        $this->link = $value;
        
        return $this;
    }

    /**
     * 导航菜单标题
     * 
     * @param string $value            
     * @return $this
     */
    public function setNavTitile(string $value): self
    {
        $this->navTitile = $value;
        
        return $this;
    }

    /**
     * 导航logo
     * 
     * @param string $value            
     * @return $this
     */
    public function setPic(string $value): self
    {
        $this->pic = $value;
        
        return $this;
    }

    /**
     * 平台【0 PC 1 WAP,2 Andriod, 3 IOS， 4微商城 】
     * 
     * @param int $value            
     * @return $this
     */
    public function setPlatform(int $value): self
    {
        $this->platform = $value;
        
        return $this;
    }

    /**
     * 排序【默认10】
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
     * 显示状态【0,不显示 1显示】
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
     * 导航类型【0默认 不选 1新】
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
     * 最后一次编辑时间
     * 
     * @param string $value            
     * @return $this
     */
    public function setUpdateTime(string $value): self
    {
        $this->updateTime = $value;
        
        return $this;
    }

    /**
     * 创建时间
     * 
     * @return string
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 导航id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 连接地址
     * 
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * 导航菜单标题
     * 
     * @return string
     */
    public function getNavTitile()
    {
        return $this->navTitile;
    }

    /**
     * 导航logo
     * 
     * @return string
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * 平台【0 PC 1 WAP,2 Andriod, 3 IOS， 4微商城 】
     * 
     * @return int
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * 排序【默认10】
     * 
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * 显示状态【0,不显示 1显示】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 导航类型【0默认 不选 1新】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 最后一次编辑时间
     * 
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
