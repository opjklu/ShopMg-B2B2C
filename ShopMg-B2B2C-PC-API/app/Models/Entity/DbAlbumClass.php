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
 * 相册表
 *
 * @Entity()
 * @Table(name="mg_album_class")
 * 
 * @uses DbAlbumClass
 */
class DbAlbumClass extends Model
{

    /**
     *
     * @var string $albCover 相册封面
     *      @Column(name="alb_cover", type="string", length=255)
     *      @Required()
     */
    private $albCover;

    /**
     *
     * @var string $albDes 相册描述
     *      @Column(name="alb_des", type="string", length=255, default="")
     */
    private $albDes;

    /**
     *
     * @var string $albName 相册名称
     *      @Column(name="alb_name", type="string", length=100)
     *      @Required()
     */
    private $albName;

    /**
     *
     * @var int $albSort 排序
     *      @Column(name="alb_sort", type="tinyint", default=255)
     */
    private $albSort;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $id 相册id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isDefault 是否默认【0否1是】
     *      @Column(name="is_default", type="tinyint", default=0)
     */
    private $isDefault;

    /**
     *
     * @var int $storeId 商家编号
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     * 相册封面
     * 
     * @param string $value            
     * @return $this
     */
    public function setAlbCover(string $value): self
    {
        $this->albCover = $value;
        
        return $this;
    }

    /**
     * 相册描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setAlbDes(string $value): self
    {
        $this->albDes = $value;
        
        return $this;
    }

    /**
     * 相册名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setAlbName(string $value): self
    {
        $this->albName = $value;
        
        return $this;
    }

    /**
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setAlbSort(int $value): self
    {
        $this->albSort = $value;
        
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
     * 相册id
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
     * 是否默认【0否1是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsDefault(int $value): self
    {
        $this->isDefault = $value;
        
        return $this;
    }

    /**
     * 商家编号
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
     * 相册封面
     * 
     * @return string
     */
    public function getAlbCover()
    {
        return $this->albCover;
    }

    /**
     * 相册描述
     * 
     * @return string
     */
    public function getAlbDes()
    {
        return $this->albDes;
    }

    /**
     * 相册名称
     * 
     * @return string
     */
    public function getAlbName()
    {
        return $this->albName;
    }

    /**
     * 排序
     * 
     * @return mixed
     */
    public function getAlbSort()
    {
        return $this->albSort;
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
     * 相册id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 是否默认【0否1是】
     * 
     * @return int
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * 商家编号
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
