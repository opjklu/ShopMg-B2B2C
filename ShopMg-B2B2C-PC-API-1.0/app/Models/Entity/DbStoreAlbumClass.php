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
 * @Table(name="mg_store_album_class")
 * 
 * @uses DbStoreAlbumClass
 */
class DbStoreAlbumClass extends Model
{

    /**
     *
     * @var string $aclassCover 相册封面
     *      @Column(name="aclass_cover", type="string", length=255, default="")
     */
    private $aclassCover;

    /**
     *
     * @var string $aclassDes 相册描述
     *      @Column(name="aclass_des", type="string", length=255, default="")
     */
    private $aclassDes;

    /**
     *
     * @var string $aclassName 相册名称
     *      @Column(name="aclass_name", type="string", length=100)
     *      @Required()
     */
    private $aclassName;

    /**
     *
     * @var int $aclassSort 排序
     *      @Column(name="aclass_sort", type="tinyint", default=50)
     */
    private $aclassSort;

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
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
     * @var int $isDefault 是否为默认相册,1代表默认
     *      @Column(name="is_default", type="tinyint", default=0)
     */
    private $isDefault;

    /**
     *
     * @var int $storeId 所属店铺id
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $uploadTime 图片上传时间
     *      @Column(name="upload_time", type="integer")
     *      @Required()
     */
    private $uploadTime;

    /**
     * 相册封面
     * 
     * @param string $value            
     * @return $this
     */
    public function setAclassCover(string $value): self
    {
        $this->aclassCover = $value;
        
        return $this;
    }

    /**
     * 相册描述
     * 
     * @param string $value            
     * @return $this
     */
    public function setAclassDes(string $value): self
    {
        $this->aclassDes = $value;
        
        return $this;
    }

    /**
     * 相册名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setAclassName(string $value): self
    {
        $this->aclassName = $value;
        
        return $this;
    }

    /**
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setAclassSort(int $value): self
    {
        $this->aclassSort = $value;
        
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
     * 是否为默认相册,1代表默认
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
     * 所属店铺id
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
     * 图片上传时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setUploadTime(int $value): self
    {
        $this->uploadTime = $value;
        
        return $this;
    }

    /**
     * 相册封面
     * 
     * @return string
     */
    public function getAclassCover()
    {
        return $this->aclassCover;
    }

    /**
     * 相册描述
     * 
     * @return string
     */
    public function getAclassDes()
    {
        return $this->aclassDes;
    }

    /**
     * 相册名称
     * 
     * @return string
     */
    public function getAclassName()
    {
        return $this->aclassName;
    }

    /**
     * 排序
     * 
     * @return mixed
     */
    public function getAclassSort()
    {
        return $this->aclassSort;
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
     * 是否为默认相册,1代表默认
     * 
     * @return int
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * 所属店铺id
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
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

    /**
     * 图片上传时间
     * 
     * @return int
     */
    public function getUploadTime()
    {
        return $this->uploadTime;
    }
}
