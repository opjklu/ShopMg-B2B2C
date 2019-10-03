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
 * 运费条件表
 *
 * @Entity()
 * @Table(name="mg_freight_condition")
 * 
 * @uses DbFreightCondition
 */
class DbFreightCondition extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="bigint", default=0)
     */
    private $createTime;

    /**
     *
     * @var int $freightId 运费主表Id
     *      @Column(name="freight_id", type="integer", default=0)
     */
    private $freightId;

    /**
     *
     * @var int $id id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var float $mailAreaMonery 包邮金额
     *      @Column(name="mail_area_monery", type="decimal", default=0)
     */
    private $mailAreaMonery;

    /**
     *
     * @var int $mailAreaNum 包邮件数，默认0
     *      @Column(name="mail_area_num", type="integer", default=0)
     */
    private $mailAreaNum;

    /**
     *
     * @var float $mailAreaVolume 包邮体积
     *      @Column(name="mail_area_volume", type="decimal", default=0)
     */
    private $mailAreaVolume;

    /**
     *
     * @var float $mailAreaWieght 包邮重量
     *      @Column(name="mail_area_wieght", type="decimal", default=0)
     */
    private $mailAreaWieght;

    /**
     *
     * @var int $updateTime 更新时间
     *      @Column(name="update_time", type="bigint", default=0)
     */
    private $updateTime;

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
     * 运费主表Id
     * 
     * @param int $value            
     * @return $this
     */
    public function setFreightId(int $value): self
    {
        $this->freightId = $value;
        
        return $this;
    }

    /**
     * id
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
     * 包邮金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setMailAreaMonery(float $value): self
    {
        $this->mailAreaMonery = $value;
        
        return $this;
    }

    /**
     * 包邮件数，默认0
     * 
     * @param int $value            
     * @return $this
     */
    public function setMailAreaNum(int $value): self
    {
        $this->mailAreaNum = $value;
        
        return $this;
    }

    /**
     * 包邮体积
     * 
     * @param float $value            
     * @return $this
     */
    public function setMailAreaVolume(float $value): self
    {
        $this->mailAreaVolume = $value;
        
        return $this;
    }

    /**
     * 包邮重量
     * 
     * @param float $value            
     * @return $this
     */
    public function setMailAreaWieght(float $value): self
    {
        $this->mailAreaWieght = $value;
        
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
     * 创建时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 运费主表Id
     * 
     * @return int
     */
    public function getFreightId()
    {
        return $this->freightId;
    }

    /**
     * id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 包邮金额
     * 
     * @return float
     */
    public function getMailAreaMonery()
    {
        return $this->mailAreaMonery;
    }

    /**
     * 包邮件数，默认0
     * 
     * @return int
     */
    public function getMailAreaNum()
    {
        return $this->mailAreaNum;
    }

    /**
     * 包邮体积
     * 
     * @return float
     */
    public function getMailAreaVolume()
    {
        return $this->mailAreaVolume;
    }

    /**
     * 包邮重量
     * 
     * @return float
     */
    public function getMailAreaWieght()
    {
        return $this->mailAreaWieght;
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
}
