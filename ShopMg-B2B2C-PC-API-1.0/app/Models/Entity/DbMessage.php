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
 * 客户订单留言
 *
 * @Entity()
 * @Table(name="mg_message")
 * 
 * @uses DbMessage
 */
class DbMessage extends Model
{

    /**
     *
     * @var string $content 留言内容
     *      @Column(name="content", type="text", length=65535)
     */
    private $content;

    /**
     *
     * @var int $createTime 留言时间
     *      @Column(name="create_time", type="integer")
     */
    private $createTime;

    /**
     *
     * @var int $id 主键id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderId 订单id
     *      @Column(name="order_id", type="integer")
     */
    private $orderId;

    /**
     * 留言内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setContent(string $value): self
    {
        $this->content = $value;
        
        return $this;
    }

    /**
     * 留言时间
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
     * 主键id
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
     * 订单id
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderId(int $value): self
    {
        $this->orderId = $value;
        
        return $this;
    }

    /**
     * 留言内容
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 留言时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 主键id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 订单id
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
}
