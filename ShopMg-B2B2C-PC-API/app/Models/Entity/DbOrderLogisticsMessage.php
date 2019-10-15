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
 * 订单物流消息表(发货时用)
 *
 * @Entity()
 * @Table(name="mg_order_logistics_message")
 * 
 * @uses DbOrderLogisticsMessage
 */
class DbOrderLogisticsMessage extends Model
{

    /**
     *
     * @var int $addtime 添加时间(发货时间)
     *      @Column(name="addtime", type="integer")
     *      @Required()
     */
    private $addtime;

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
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var int $status 0未读1已读
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $userId 用户id
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 添加时间(发货时间)
     * 
     * @param int $value            
     * @return $this
     */
    public function setAddtime(int $value): self
    {
        $this->addtime = $value;
        
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
     * 0未读1已读
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
     * 用户id
     * 
     * @param int $value            
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->userId = $value;
        
        return $this;
    }

    /**
     * 添加时间(发货时间)
     * 
     * @return int
     */
    public function getAddtime()
    {
        return $this->addtime;
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

    /**
     * 0未读1已读
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 用户id
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
