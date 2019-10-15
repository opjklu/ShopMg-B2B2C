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
 * 店铺消息接收设置
 *
 * @Entity()
 * @Table(name="mg_store_msg_setting")
 * 
 * @uses DbStoreMsgSetting
 */
class DbStoreMsgSetting extends Model
{

    /**
     *
     * @var int $id 编号
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $smsMailSwitch 邮件接收开关，0关闭，1开启
     *      @Column(name="sms_mail_switch", type="tinyint")
     *      @Required()
     */
    private $smsMailSwitch;

    /**
     *
     * @var int $smsMessageSwitch 站内信接收开关，0关闭，1开启
     *      @Column(name="sms_message_switch", type="tinyint")
     *      @Required()
     */
    private $smsMessageSwitch;

    /**
     *
     * @var int $smsShortSwitch 短消息接收开关，0关闭，1开启
     *      @Column(name="sms_short_switch", type="tinyint")
     *      @Required()
     */
    private $smsShortSwitch;

    /**
     *
     * @var string $smtCode 模板编码
     *      @Id()
     *      @Column(name="smt_code", type="string", length=100)
     */
    private $smtCode;

    /**
     *
     * @var int $storeId 店铺id
     *      @Id()
     *      @Column(name="store_id", type="integer")
     */
    private $storeId;

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
     * 邮件接收开关，0关闭，1开启
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmsMailSwitch(int $value): self
    {
        $this->smsMailSwitch = $value;
        
        return $this;
    }

    /**
     * 站内信接收开关，0关闭，1开启
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmsMessageSwitch(int $value): self
    {
        $this->smsMessageSwitch = $value;
        
        return $this;
    }

    /**
     * 短消息接收开关，0关闭，1开启
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmsShortSwitch(int $value): self
    {
        $this->smsShortSwitch = $value;
        
        return $this;
    }

    /**
     * 模板编码
     * 
     * @param string $value            
     * @return $this
     */
    public function setSmtCode(string $value)
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
    public function setStoreId(int $value)
    {
        $this->storeId = $value;
        
        return $this;
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
     * 邮件接收开关，0关闭，1开启
     * 
     * @return int
     */
    public function getSmsMailSwitch()
    {
        return $this->smsMailSwitch;
    }

    /**
     * 站内信接收开关，0关闭，1开启
     * 
     * @return int
     */
    public function getSmsMessageSwitch()
    {
        return $this->smsMessageSwitch;
    }

    /**
     * 短消息接收开关，0关闭，1开启
     * 
     * @return int
     */
    public function getSmsShortSwitch()
    {
        return $this->smsShortSwitch;
    }

    /**
     * 模板编码
     * 
     * @return mixed
     */
    public function getSmtCode()
    {
        return $this->smtCode;
    }

    /**
     * 店铺id
     * 
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->storeId;
    }
}
