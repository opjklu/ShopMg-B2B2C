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
 * 公告表
 *
 * @Entity()
 * @Table(name="mg_single")
 * 
 * @uses DbSingle
 */
class DbSingle extends Model
{

    /**
     *
     * @var int $createTime 创建时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $id 单页表
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var string $singleInfo 内容
     *      @Column(name="single_info", type="text", length=65535)
     */
    private $singleInfo;

    /**
     *
     * @var string $singleTitle 标题
     *      @Column(name="single_title", type="string", length=20)
     */
    private $singleTitle;

    /**
     *
     * @var string $type @Column(name="type", type="string", length=10)
     */
    private $type;

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
     * 单页表
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
     * 内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setSingleInfo(string $value): self
    {
        $this->singleInfo = $value;
        
        return $this;
    }

    /**
     * 标题
     * 
     * @param string $value            
     * @return $this
     */
    public function setSingleTitle(string $value): self
    {
        $this->singleTitle = $value;
        
        return $this;
    }

    /**
     *
     * @param string $value            
     * @return $this
     */
    public function setType(string $value): self
    {
        $this->type = $value;
        
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
     * 单页表
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 内容
     * 
     * @return string
     */
    public function getSingleInfo()
    {
        return $this->singleInfo;
    }

    /**
     * 标题
     * 
     * @return string
     */
    public function getSingleTitle()
    {
        return $this->singleTitle;
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
