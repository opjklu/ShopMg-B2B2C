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
 * 商家消息模板表
 *
 * @Entity()
 * @Table(name="mg_store_msg_tpl")
 * 
 * @uses DbStoreMsgTpl
 */
class DbStoreMsgTpl extends Model
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
     * @var string $smtCode 模板编码
     *      @Column(name="smt_code", type="string", length=100)
     *      @Required()
     */
    private $smtCode;

    /**
     *
     * @var string $smtMailContent 邮件内容
     *      @Column(name="smt_mail_content", type="text", length=65535)
     *      @Required()
     */
    private $smtMailContent;

    /**
     *
     * @var int $smtMailForced 邮件强制接收【0否，1是】
     *      @Column(name="smt_mail_forced", type="tinyint")
     *      @Required()
     */
    private $smtMailForced;

    /**
     *
     * @var string $smtMailSubject 邮件标题
     *      @Column(name="smt_mail_subject", type="string", length=255)
     *      @Required()
     */
    private $smtMailSubject;

    /**
     *
     * @var int $smtMailSwitch 邮件默认开【0关，1开】
     *      @Column(name="smt_mail_switch", type="tinyint")
     *      @Required()
     */
    private $smtMailSwitch;

    /**
     *
     * @var string $smtMessageContent 站内信内容
     *      @Column(name="smt_message_content", type="string", length=255)
     *      @Required()
     */
    private $smtMessageContent;

    /**
     *
     * @var int $smtMessageForced 站内信强制接收【0否，1是】
     *      @Column(name="smt_message_forced", type="tinyint")
     *      @Required()
     */
    private $smtMessageForced;

    /**
     *
     * @var int $smtMessageSwitch 站内信默认开关【0关，1开】
     *      @Column(name="smt_message_switch", type="tinyint")
     *      @Required()
     */
    private $smtMessageSwitch;

    /**
     *
     * @var string $smtName 模板名称
     *      @Column(name="smt_name", type="string", length=100)
     *      @Required()
     */
    private $smtName;

    /**
     *
     * @var string $smtShortContent 短信内容
     *      @Column(name="smt_short_content", type="string", length=255)
     *      @Required()
     */
    private $smtShortContent;

    /**
     *
     * @var int $smtShortForced 短信强制接收【0否，1是】
     *      @Column(name="smt_short_forced", type="tinyint")
     *      @Required()
     */
    private $smtShortForced;

    /**
     *
     * @var int $smtShortSwitch 短信默认开关【0关，1开】
     *      @Column(name="smt_short_switch", type="tinyint")
     *      @Required()
     */
    private $smtShortSwitch;

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
     * 模板编码
     * 
     * @param string $value            
     * @return $this
     */
    public function setSmtCode(string $value): self
    {
        $this->smtCode = $value;
        
        return $this;
    }

    /**
     * 邮件内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setSmtMailContent(string $value): self
    {
        $this->smtMailContent = $value;
        
        return $this;
    }

    /**
     * 邮件强制接收【0否，1是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmtMailForced(int $value): self
    {
        $this->smtMailForced = $value;
        
        return $this;
    }

    /**
     * 邮件标题
     * 
     * @param string $value            
     * @return $this
     */
    public function setSmtMailSubject(string $value): self
    {
        $this->smtMailSubject = $value;
        
        return $this;
    }

    /**
     * 邮件默认开【0关，1开】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmtMailSwitch(int $value): self
    {
        $this->smtMailSwitch = $value;
        
        return $this;
    }

    /**
     * 站内信内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setSmtMessageContent(string $value): self
    {
        $this->smtMessageContent = $value;
        
        return $this;
    }

    /**
     * 站内信强制接收【0否，1是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmtMessageForced(int $value): self
    {
        $this->smtMessageForced = $value;
        
        return $this;
    }

    /**
     * 站内信默认开关【0关，1开】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmtMessageSwitch(int $value): self
    {
        $this->smtMessageSwitch = $value;
        
        return $this;
    }

    /**
     * 模板名称
     * 
     * @param string $value            
     * @return $this
     */
    public function setSmtName(string $value): self
    {
        $this->smtName = $value;
        
        return $this;
    }

    /**
     * 短信内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setSmtShortContent(string $value): self
    {
        $this->smtShortContent = $value;
        
        return $this;
    }

    /**
     * 短信强制接收【0否，1是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmtShortForced(int $value): self
    {
        $this->smtShortForced = $value;
        
        return $this;
    }

    /**
     * 短信默认开关【0关，1开】
     * 
     * @param int $value            
     * @return $this
     */
    public function setSmtShortSwitch(int $value): self
    {
        $this->smtShortSwitch = $value;
        
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
     * 模板编码
     * 
     * @return string
     */
    public function getSmtCode()
    {
        return $this->smtCode;
    }

    /**
     * 邮件内容
     * 
     * @return string
     */
    public function getSmtMailContent()
    {
        return $this->smtMailContent;
    }

    /**
     * 邮件强制接收【0否，1是】
     * 
     * @return int
     */
    public function getSmtMailForced()
    {
        return $this->smtMailForced;
    }

    /**
     * 邮件标题
     * 
     * @return string
     */
    public function getSmtMailSubject()
    {
        return $this->smtMailSubject;
    }

    /**
     * 邮件默认开【0关，1开】
     * 
     * @return int
     */
    public function getSmtMailSwitch()
    {
        return $this->smtMailSwitch;
    }

    /**
     * 站内信内容
     * 
     * @return string
     */
    public function getSmtMessageContent()
    {
        return $this->smtMessageContent;
    }

    /**
     * 站内信强制接收【0否，1是】
     * 
     * @return int
     */
    public function getSmtMessageForced()
    {
        return $this->smtMessageForced;
    }

    /**
     * 站内信默认开关【0关，1开】
     * 
     * @return int
     */
    public function getSmtMessageSwitch()
    {
        return $this->smtMessageSwitch;
    }

    /**
     * 模板名称
     * 
     * @return string
     */
    public function getSmtName()
    {
        return $this->smtName;
    }

    /**
     * 短信内容
     * 
     * @return string
     */
    public function getSmtShortContent()
    {
        return $this->smtShortContent;
    }

    /**
     * 短信强制接收【0否，1是】
     * 
     * @return int
     */
    public function getSmtShortForced()
    {
        return $this->smtShortForced;
    }

    /**
     * 短信默认开关【0关，1开】
     * 
     * @return int
     */
    public function getSmtShortSwitch()
    {
        return $this->smtShortSwitch;
    }
}
