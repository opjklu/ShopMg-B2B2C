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
 * 店铺消息阅读表
 *
 * @Entity()
 * @Table(name="mg_store_msg_read")
 * 
 * @uses DbStoreMsgRead
 */
class DbStoreMsgRead extends Model
{

    /**
     *
     * @var int $readTime 阅读时间
     *      @Column(name="read_time", type="integer")
     *      @Required()
     */
    private $readTime;

    /**
     *
     * @var int $sellerId 卖家id
     *      @Id()
     *      @Column(name="seller_id", type="integer")
     */
    private $sellerId;

    /**
     *
     * @var int $smId 店铺消息id
     *      @Id()
     *      @Column(name="sm_id", type="integer")
     */
    private $smId;

    /**
     * 阅读时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setReadTime(int $value): self
    {
        $this->readTime = $value;
        
        return $this;
    }

    /**
     * 卖家id
     * 
     * @param int $value            
     * @return $this
     */
    public function setSellerId(int $value)
    {
        $this->sellerId = $value;
        
        return $this;
    }

    /**
     * 店铺消息id
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmId(int $value)
    {
        $this->smId = $value;
        
        return $this;
    }

    /**
     * 阅读时间
     * 
     * @return int
     */
    public function getReadTime()
    {
        return $this->readTime;
    }

    /**
     * 卖家id
     * 
     * @return mixed
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }

    /**
     * 店铺消息id
     * 
     * @return mixed
     */
    public function getSmId()
    {
        return $this->smId;
    }
}
