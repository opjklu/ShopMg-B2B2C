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
 * 相册图片表
 *
 * @Entity()
 * @Table(name="mg_album_pic")
 * 
 * @uses DbAlbumPic
 */
class DbAlbumPic extends Model
{

    /**
     *
     * @var int $albId 相册id
     *      @Column(name="alb_id", type="integer")
     *      @Required()
     */
    private $albId;

    /**
     *
     * @var int $createTime 上传时间
     *      @Column(name="create_time", type="integer")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $id 图片编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isCover 是否为封面 1为是 0为否
     *      @Column(name="is_cover", type="tinyint")
     *      @Required()
     */
    private $isCover;

    /**
     *
     * @var string $picMeasure 图片尺寸
     *      @Column(name="pic_measure", type="string", length=255)
     *      @Required()
     */
    private $picMeasure;

    /**
     *
     * @var string $picName 图片名称
     *      @Column(name="pic_name", type="string", length=100)
     */
    private $picName;

    /**
     *
     * @var string $picPath 图片路径
     *      @Column(name="pic_path", type="string", length=255)
     *      @Required()
     */
    private $picPath;

    /**
     *
     * @var int $picSize 图片大小
     *      @Column(name="pic_size", type="integer")
     *      @Required()
     */
    private $picSize;

    /**
     *
     * @var int $picSort 排序
     *      @Column(name="pic_sort", type="integer", default=0)
     */
    private $picSort;

    /**
     *
     * @var string $picType 图片类型
     *      @Column(name="pic_type", type="string", length=100)
     *      @Required()
     */
    private $picType;

    /**
     * 相册id
     * 
     * @param int $value            
     * @return $this
     */
    public function setAlbId(int $value): self
    {
        $this->albId = $value;
        
        return $this;
    }

    /**
     * 上传时间
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
     * 图片编号
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
     * 是否为封面 1为是 0为否
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsCover(int $value): self
    {
        $this->isCover = $value;
        
        return $this;
    }

    /**
     * 图片尺寸
     * 
     * @param string $value            
     * @return $this
     */
    public function setPicMeasure(string $value): self
    {
        $this->picMeasure = $value;
        
        return $this;
    }

    /**
     * 图片名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setPicName(string $value): self
    {
        $this->picName = $value;
        
        return $this;
    }

    /**
     * 图片路径
     * 
     * @param string $value            
     * @return $this
     */
    public function setPicPath(string $value): self
    {
        $this->picPath = $value;
        
        return $this;
    }

    /**
     * 图片大小
     * 
     * @param int $value            
     * @return $this
     */
    public function setPicSize(int $value): self
    {
        $this->picSize = $value;
        
        return $this;
    }

    /**
     * 排序
     * 
     * @param int $value            
     * @return $this
     */
    public function setPicSort(int $value): self
    {
        $this->picSort = $value;
        
        return $this;
    }

    /**
     * 图片类型
     * 
     * @param string $value            
     * @return $this
     */
    public function setPicType(string $value): self
    {
        $this->picType = $value;
        
        return $this;
    }

    /**
     * 相册id
     * 
     * @return int
     */
    public function getAlbId()
    {
        return $this->albId;
    }

    /**
     * 上传时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 图片编号
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 是否为封面 1为是 0为否
     * 
     * @return int
     */
    public function getIsCover()
    {
        return $this->isCover;
    }

    /**
     * 图片尺寸
     * 
     * @return string
     */
    public function getPicMeasure()
    {
        return $this->picMeasure;
    }

    /**
     * 图片名称
     * 
     * @return string
     */
    public function getPicName()
    {
        return $this->picName;
    }

    /**
     * 图片路径
     * 
     * @return string
     */
    public function getPicPath()
    {
        return $this->picPath;
    }

    /**
     * 图片大小
     * 
     * @return int
     */
    public function getPicSize()
    {
        return $this->picSize;
    }

    /**
     * 排序
     * 
     * @return int
     */
    public function getPicSort()
    {
        return $this->picSort;
    }

    /**
     * 图片类型
     * 
     * @return string
     */
    public function getPicType()
    {
        return $this->picType;
    }
}
