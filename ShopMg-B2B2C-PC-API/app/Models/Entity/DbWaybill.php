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
 * 快递单打印模板表
 *
 * @Entity()
 * @Table(name="mg_waybill")
 * 
 * @uses DbWaybill
 */
class DbWaybill extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint")
     *      @Required()
     */
    private $createTime;

    /**
     *
     * @var int $expressId 快递公司【编号】
     *      @Column(name="express_id", type="tinyint")
     *      @Required()
     */
    private $expressId;

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $waybillHeight 高度
     *      @Column(name="waybill_height", type="integer")
     *      @Required()
     */
    private $waybillHeight;

    /**
     *
     * @var string $waybillImage 图片路径
     *      @Column(name="waybill_image", type="string", length=150)
     *      @Required()
     */
    private $waybillImage;

    /**
     *
     * @var int $waybillLeft 左偏移量
     *      @Column(name="waybill_left", type="integer", default=0)
     */
    private $waybillLeft;

    /**
     *
     * @var string $waybillName 运单模板名称
     *      @Column(name="waybill_name", type="string", length=50)
     *      @Required()
     */
    private $waybillName;

    /**
     *
     * @var int $waybillTop 上偏移量
     *      @Column(name="waybill_top", type="integer", default=0)
     */
    private $waybillTop;

    /**
     *
     * @var int $waybillUsable 是否可用
     *      @Column(name="waybill_usable", type="tinyint", default=0)
     */
    private $waybillUsable;

    /**
     *
     * @var int $waybillWidth 宽度
     *      @Column(name="waybill_width", type="integer")
     *      @Required()
     */
    private $waybillWidth;

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
     * 快递公司【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setExpressId(int $value): self
    {
        $this->expressId = $value;
        
        return $this;
    }

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
     * 高度
     * 
     * @param int $value            
     * @return $this
     */
    public function setWaybillHeight(int $value): self
    {
        $this->waybillHeight = $value;
        
        return $this;
    }

    /**
     * 图片路径
     * 
     * @param string $value            
     * @return $this
     */
    public function setWaybillImage(string $value): self
    {
        $this->waybillImage = $value;
        
        return $this;
    }

    /**
     * 左偏移量
     * 
     * @param int $value            
     * @return $this
     */
    public function setWaybillLeft(int $value): self
    {
        $this->waybillLeft = $value;
        
        return $this;
    }

    /**
     * 运单模板名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setWaybillName(string $value): self
    {
        $this->waybillName = $value;
        
        return $this;
    }

    /**
     * 上偏移量
     * 
     * @param int $value            
     * @return $this
     */
    public function setWaybillTop(int $value): self
    {
        $this->waybillTop = $value;
        
        return $this;
    }

    /**
     * 是否可用
     * 
     * @param int $value            
     * @return $this
     */
    public function setWaybillUsable(int $value): self
    {
        $this->waybillUsable = $value;
        
        return $this;
    }

    /**
     * 宽度
     * 
     * @param int $value            
     * @return $this
     */
    public function setWaybillWidth(int $value): self
    {
        $this->waybillWidth = $value;
        
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
     * 快递公司【编号】
     * 
     * @return int
     */
    public function getExpressId()
    {
        return $this->expressId;
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
     * 更新时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * 高度
     * 
     * @return int
     */
    public function getWaybillHeight()
    {
        return $this->waybillHeight;
    }

    /**
     * 图片路径
     * 
     * @return string
     */
    public function getWaybillImage()
    {
        return $this->waybillImage;
    }

    /**
     * 左偏移量
     * 
     * @return int
     */
    public function getWaybillLeft()
    {
        return $this->waybillLeft;
    }

    /**
     * 运单模板名称
     * 
     * @return string
     */
    public function getWaybillName()
    {
        return $this->waybillName;
    }

    /**
     * 上偏移量
     * 
     * @return int
     */
    public function getWaybillTop()
    {
        return $this->waybillTop;
    }

    /**
     * 是否可用
     * 
     * @return int
     */
    public function getWaybillUsable()
    {
        return $this->waybillUsable;
    }

    /**
     * 宽度
     * 
     * @return int
     */
    public function getWaybillWidth()
    {
        return $this->waybillWidth;
    }
}
