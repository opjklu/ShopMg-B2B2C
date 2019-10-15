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
 * 店铺消息表
 *
 * @Entity()
 * @Table(name="mg_store_msg")
 * 
 * @uses DbStoreMsg
 */
class DbStoreMsg extends Model
{

    /**
     *
     * @var int $id 店铺消息id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $smAddtime 发送时间
     *      @Column(name="sm_addtime", type="integer")
     *      @Required()
     */
    private $smAddtime;

    /**
     *
     * @var string $smContent 消息内容
     *      @Column(name="sm_content", type="string", length=255)
     *      @Required()
     */
    private $smContent;

    /**
     *
     * @var int $smtCode 模板编码
     *      @Column(name="smt_code", type="integer", default=0)
     */
    private $smtCode;

    /**
     *
     * @var int $storeId 店铺id
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     * 店铺消息id
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
     * 发送时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmAddtime(int $value): self
    {
        $this->smAddtime = $value;
        
        return $this;
    }

    /**
     * 消息内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setSmContent(string $value): self
    {
        $this->smContent = $value;
        
        return $this;
    }

    /**
     * 模板编码
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmtCode(int $value): self
    {
        $this->smtCode = $value;
        
        return $this;
    }

    /**
     * 店铺id
     * 
     * @param int $value            
     * @return $this
     */
    public function setStoreId(int $value): self
    {
        $this->storeId = $value;
        
        return $this;
    }

    /**
     * 店铺消息id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 发送时间
     * 
     * @return int
     */
    public function getSmAddtime()
    {
        return $this->smAddtime;
    }

    /**
     * 消息内容
     * 
     * @return string
     */
    public function getSmContent()
    {
        return $this->smContent;
    }

    /**
     * 模板编码
     * 
     * @return int
     */
    public function getSmtCode()
    {
        return $this->smtCode;
    }

    /**
     * 店铺id
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
