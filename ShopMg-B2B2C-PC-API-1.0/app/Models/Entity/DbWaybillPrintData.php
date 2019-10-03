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
 * 打印位置数据表
 *
 * @Entity()
 * @Table(name="mg_waybill_print_data")
 * 
 * @uses DbWaybillPrintData
 */
class DbWaybillPrintData extends Model
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
     * @var float $dialogHeight 高度偏移量（毫米）
     *      @Column(name="dialog_height", type="double")
     *      @Required()
     */
    private $dialogHeight;

    /**
     *
     * @var float $dialogLeft 做偏移量（毫米）
     *      @Column(name="dialog_left", type="double", default=0)
     */
    private $dialogLeft;

    /**
     *
     * @var float $dialogTop 上偏移量（毫米）
     *      @Column(name="dialog_top", type="double")
     *      @Required()
     */
    private $dialogTop;

    /**
     *
     * @var float $dialogWidth 宽度偏移量
     *      @Column(name="dialog_width", type="double")
     *      @Required()
     */
    private $dialogWidth;

    /**
     *
     * @var int $id @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $printId 打印项编号
     *      @Column(name="print_id", type="integer", default=0)
     */
    private $printId;

    /**
     *
     * @var string $printItem 打印项
     *      @Column(name="print_item", type="string", length=50)
     *      @Required()
     */
    private $printItem;

    /**
     *
     * @var int $status 状态【0 废弃 1打印】
     *      @Column(name="status", type="tinyint", default=1)
     */
    private $status;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint")
     *      @Required()
     */
    private $updateTime;

    /**
     *
     * @var int $waybillId 运单【编号】
     *      @Column(name="waybill_id", type="integer", default=0)
     */
    private $waybillId;

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
     * 高度偏移量（毫米）
     * 
     * @param float $value            
     * @return $this
     */
    public function setDialogHeight(float $value): self
    {
        $this->dialogHeight = $value;
        
        return $this;
    }

    /**
     * 做偏移量（毫米）
     * 
     * @param float $value            
     * @return $this
     */
    public function setDialogLeft(float $value): self
    {
        $this->dialogLeft = $value;
        
        return $this;
    }

    /**
     * 上偏移量（毫米）
     * 
     * @param float $value            
     * @return $this
     */
    public function setDialogTop(float $value): self
    {
        $this->dialogTop = $value;
        
        return $this;
    }

    /**
     * 宽度偏移量
     * 
     * @param float $value            
     * @return $this
     */
    public function setDialogWidth(float $value): self
    {
        $this->dialogWidth = $value;
        
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
     * 打印项编号
     * 
     * @param int $value            
     * @return $this
     */
    public function setPrintId(int $value): self
    {
        $this->printId = $value;
        
        return $this;
    }

    /**
     * 打印项
     * 
     * @param string $value            
     * @return $this
     */
    public function setPrintItem(string $value): self
    {
        $this->printItem = $value;
        
        return $this;
    }

    /**
     * 状态【0 废弃 1打印】
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
     * 运单【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setWaybillId(int $value): self
    {
        $this->waybillId = $value;
        
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
     * 高度偏移量（毫米）
     * 
     * @return float
     */
    public function getDialogHeight()
    {
        return $this->dialogHeight;
    }

    /**
     * 做偏移量（毫米）
     * 
     * @return mixed
     */
    public function getDialogLeft()
    {
        return $this->dialogLeft;
    }

    /**
     * 上偏移量（毫米）
     * 
     * @return float
     */
    public function getDialogTop()
    {
        return $this->dialogTop;
    }

    /**
     * 宽度偏移量
     * 
     * @return float
     */
    public function getDialogWidth()
    {
        return $this->dialogWidth;
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
     * 打印项编号
     * 
     * @return int
     */
    public function getPrintId()
    {
        return $this->printId;
    }

    /**
     * 打印项
     * 
     * @return string
     */
    public function getPrintItem()
    {
        return $this->printItem;
    }

    /**
     * 状态【0 废弃 1打印】
     * 
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
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
     * 运单【编号】
     * 
     * @return int
     */
    public function getWaybillId()
    {
        return $this->waybillId;
    }
}
