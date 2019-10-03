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
 * 广告分类表
 *
 * @Entity()
 * @Table(name="mg_ad_space")
 * 
 * @uses DbAdSpace
 */
class DbAdSpace extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $height 高
     *      @Column(name="height", type="integer")
     */
    private $height;

    /**
     *
     * @var int $id 广告id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isOpen 是否打开广告位:1.打开 0.关闭
     *      @Column(name="is_open", type="tinyint", default=0)
     */
    private $isOpen;

    /**
     *
     * @var string $name 广告名称
     *      @Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     *
     * @var string $remark 评论
     *      @Column(name="remark", type="string", length=50)
     */
    private $remark;

    /**
     *
     * @var int $type 广告类型【0 pc, 1 wap, 2,app】
     *      @Column(name="type", type="tinyint")
     */
    private $type;

    /**
     *
     * @var int $updateTime 修改时间
     *      @Column(name="update_time", type="integer")
     */
    private $updateTime;

    /**
     *
     * @var int $width 宽
     *      @Column(name="width", type="integer")
     */
    private $width;

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
     * 高
     * 
     * @param int $value            
     * @return $this
     */
    public function setHeight(int $value): self
    {
        $this->height = $value;
        
        return $this;
    }

    /**
     * 广告id
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
     * 是否打开广告位:1.打开 0.关闭
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsOpen(int $value): self
    {
        $this->isOpen = $value;
        
        return $this;
    }

    /**
     * 广告名称
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
     * 评论
     * 
     * @param string $value            
     * @return $this
     */
    public function setRemark(string $value): self
    {
        $this->remark = $value;
        
        return $this;
    }

    /**
     * 广告类型【0 pc, 1 wap, 2,app】
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
     * 修改时间
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
     * 宽
     * 
     * @param int $value            
     * @return $this
     */
    public function setWidth(int $value): self
    {
        $this->width = $value;
        
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
     * 高
     * 
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * 广告id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 是否打开广告位:1.打开 0.关闭
     * 
     * @return int
     */
    public function getIsOpen()
    {
        return $this->isOpen;
    }

    /**
     * 广告名称
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 评论
     * 
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * 广告类型【0 pc, 1 wap, 2,app】
     * 
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 修改时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 宽
     * 
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
}
