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
 * 订单用户表
 *
 * @Entity()
 * @Table(name="mg_order_user")
 * 
 * @uses DbOrderUser
 */
class DbOrderUser extends Model
{

    /**
     *
     * @var int $id 主键
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderId 订单编号
     *      @Column(name="order_id", type="integer")
     *      @Required()
     */
    private $orderId;

    /**
     *
     * @var int $userId 用户编号
     *      @Column(name="user_id", type="integer")
     *      @Required()
     */
    private $userId;

    /**
     * 主键
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
     * 订单编号
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
     * 用户编号
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
     * 主键
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 订单编号
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 用户编号
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
