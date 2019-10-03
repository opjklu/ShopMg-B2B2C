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
 * 投诉表
 *
 * @Entity()
 * @Table(name="mg_complain")
 * 
 * @uses DbComplain
 */
class DbComplain extends Model
{

    /**
     *
     * @var int $accusedId 被告id
     *      @Column(name="accused_id", type="integer")
     *      @Required()
     */
    private $accusedId;

    /**
     *
     * @var int $accuserId 原告id
     *      @Column(name="accuser_id", type="integer")
     *      @Required()
     */
    private $accuserId;

    /**
     *
     * @var int $appealDatetime 申诉时间
     *      @Column(name="appeal_datetime", type="integer")
     */
    private $appealDatetime;

    /**
     *
     * @var string $appealMessage 申诉内容
     *      @Column(name="appeal_message", type="string", length=255)
     */
    private $appealMessage;

    /**
     *
     * @var string $appealPic1 申诉图片1
     *      @Column(name="appeal_pic1", type="string", length=100)
     */
    private $appealPic1;

    /**
     *
     * @var string $appealPic2 申诉图片2
     *      @Column(name="appeal_pic2", type="string", length=100)
     */
    private $appealPic2;

    /**
     *
     * @var string $appealPic3 申诉图片3
     *      @Column(name="appeal_pic3", type="string", length=100)
     */
    private $appealPic3;

    /**
     *
     * @var int $complainActive 投诉是否通过平台审批【0未通过/1通过】
     *      @Column(name="complain_active", type="tinyint", default=1)
     */
    private $complainActive;

    /**
     *
     * @var string $complainContent 投诉内容
     *      @Column(name="complain_content", type="string", length=255)
     */
    private $complainContent;

    /**
     *
     * @var int $complainDatetime 投诉时间
     *      @Column(name="complain_datetime", type="bigint")
     *      @Required()
     */
    private $complainDatetime;

    /**
     *
     * @var int $complainId 投诉主题id
     *      @Column(name="complain_id", type="integer")
     *      @Required()
     */
    private $complainId;

    /**
     *
     * @var string $complainPic1 投诉图片1
     *      @Column(name="complain_pic1", type="string", length=100)
     */
    private $complainPic1;

    /**
     *
     * @var string $complainPic2 投诉图片2
     *      @Column(name="complain_pic2", type="string", length=100)
     */
    private $complainPic2;

    /**
     *
     * @var string $complainPic3 投诉图片3
     *      @Column(name="complain_pic3", type="string", length=100)
     */
    private $complainPic3;

    /**
     *
     * @var int $complainState 投诉状态【0-新投诉/1-投诉通过转给被投诉人/2-被投诉人已申诉/3-提交仲裁/4-已关闭】
     *      @Column(name="complain_state", type="tinyint")
     *      @Required()
     */
    private $complainState;

    /**
     *
     * @var int $finalDatetime 最终处理时间
     *      @Column(name="final_datetime", type="integer")
     */
    private $finalDatetime;

    /**
     *
     * @var int $finalId 最终处理人【id】
     *      @Column(name="final_id", type="integer")
     */
    private $finalId;

    /**
     *
     * @var string $finalMessage 最终处理意见
     *      @Column(name="final_message", type="string", length=255)
     */
    private $finalMessage;

    /**
     *
     * @var int $handleDatetime 投诉处理时间
     *      @Column(name="handle_datetime", type="bigint")
     */
    private $handleDatetime;

    /**
     *
     * @var int $handleMemberId 投诉处理人id
     *      @Column(name="handle_member_id", type="integer")
     */
    private $handleMemberId;

    /**
     *
     * @var int $id 投诉id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $orderGoodsId 订单商品ID
     *      @Column(name="order_goods_id", type="integer", default=0)
     */
    private $orderGoodsId;

    /**
     *
     * @var int $orderId 订单id
     *      @Column(name="order_id", type="integer")
     *      @Required()
     */
    private $orderId;

    /**
     * 被告id
     * 
     * @param int $value            
     * @return $this
     */
    public function setAccusedId(int $value): self
    {
        $this->accusedId = $value;
        
        return $this;
    }

    /**
     * 原告id
     * 
     * @param int $value            
     * @return $this
     */
    public function setAccuserId(int $value): self
    {
        $this->accuserId = $value;
        
        return $this;
    }

    /**
     * 申诉时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setAppealDatetime(int $value): self
    {
        $this->appealDatetime = $value;
        
        return $this;
    }

    /**
     * 申诉内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setAppealMessage(string $value): self
    {
        $this->appealMessage = $value;
        
        return $this;
    }

    /**
     * 申诉图片1
     * 
     * @param string $value            
     * @return $this
     */
    public function setAppealPic1(string $value): self
    {
        $this->appealPic1 = $value;
        
        return $this;
    }

    /**
     * 申诉图片2
     * 
     * @param string $value            
     * @return $this
     */
    public function setAppealPic2(string $value): self
    {
        $this->appealPic2 = $value;
        
        return $this;
    }

    /**
     * 申诉图片3
     * 
     * @param string $value            
     * @return $this
     */
    public function setAppealPic3(string $value): self
    {
        $this->appealPic3 = $value;
        
        return $this;
    }

    /**
     * 投诉是否通过平台审批【0未通过/1通过】
     * 
     * @param int $value            
     * @return $this
     */
    public function setComplainActive(int $value): self
    {
        $this->complainActive = $value;
        
        return $this;
    }

    /**
     * 投诉内容
     * 
     * @param string $value            
     * @return $this
     */
    public function setComplainContent(string $value): self
    {
        $this->complainContent = $value;
        
        return $this;
    }

    /**
     * 投诉时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setComplainDatetime(int $value): self
    {
        $this->complainDatetime = $value;
        
        return $this;
    }

    /**
     * 投诉主题id
     * 
     * @param int $value            
     * @return $this
     */
    public function setComplainId(int $value): self
    {
        $this->complainId = $value;
        
        return $this;
    }

    /**
     * 投诉图片1
     * 
     * @param string $value            
     * @return $this
     */
    public function setComplainPic1(string $value): self
    {
        $this->complainPic1 = $value;
        
        return $this;
    }

    /**
     * 投诉图片2
     * 
     * @param string $value            
     * @return $this
     */
    public function setComplainPic2(string $value): self
    {
        $this->complainPic2 = $value;
        
        return $this;
    }

    /**
     * 投诉图片3
     * 
     * @param string $value            
     * @return $this
     */
    public function setComplainPic3(string $value): self
    {
        $this->complainPic3 = $value;
        
        return $this;
    }

    /**
     * 投诉状态【0-新投诉/1-投诉通过转给被投诉人/2-被投诉人已申诉/3-提交仲裁/4-已关闭】
     * 
     * @param int $value            
     * @return $this
     */
    public function setComplainState(int $value): self
    {
        $this->complainState = $value;
        
        return $this;
    }

    /**
     * 最终处理时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setFinalDatetime(int $value): self
    {
        $this->finalDatetime = $value;
        
        return $this;
    }

    /**
     * 最终处理人【id】
     * 
     * @param int $value            
     * @return $this
     */
    public function setFinalId(int $value): self
    {
        $this->finalId = $value;
        
        return $this;
    }

    /**
     * 最终处理意见
     * 
     * @param string $value            
     * @return $this
     */
    public function setFinalMessage(string $value): self
    {
        $this->finalMessage = $value;
        
        return $this;
    }

    /**
     * 投诉处理时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setHandleDatetime(int $value): self
    {
        $this->handleDatetime = $value;
        
        return $this;
    }

    /**
     * 投诉处理人id
     * 
     * @param int $value            
     * @return $this
     */
    public function setHandleMemberId(int $value): self
    {
        $this->handleMemberId = $value;
        
        return $this;
    }

    /**
     * 投诉id
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
     * 订单商品ID
     * 
     * @param int $value            
     * @return $this
     */
    public function setOrderGoodsId(int $value): self
    {
        $this->orderGoodsId = $value;
        
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
     * 被告id
     * 
     * @return int
     */
    public function getAccusedId()
    {
        return $this->accusedId;
    }

    /**
     * 原告id
     * 
     * @return int
     */
    public function getAccuserId()
    {
        return $this->accuserId;
    }

    /**
     * 申诉时间
     * 
     * @return int
     */
    public function getAppealDatetime()
    {
        return $this->appealDatetime;
    }

    /**
     * 申诉内容
     * 
     * @return string
     */
    public function getAppealMessage()
    {
        return $this->appealMessage;
    }

    /**
     * 申诉图片1
     * 
     * @return string
     */
    public function getAppealPic1()
    {
        return $this->appealPic1;
    }

    /**
     * 申诉图片2
     * 
     * @return string
     */
    public function getAppealPic2()
    {
        return $this->appealPic2;
    }

    /**
     * 申诉图片3
     * 
     * @return string
     */
    public function getAppealPic3()
    {
        return $this->appealPic3;
    }

    /**
     * 投诉是否通过平台审批【0未通过/1通过】
     * 
     * @return mixed
     */
    public function getComplainActive()
    {
        return $this->complainActive;
    }

    /**
     * 投诉内容
     * 
     * @return string
     */
    public function getComplainContent()
    {
        return $this->complainContent;
    }

    /**
     * 投诉时间
     * 
     * @return int
     */
    public function getComplainDatetime()
    {
        return $this->complainDatetime;
    }

    /**
     * 投诉主题id
     * 
     * @return int
     */
    public function getComplainId()
    {
        return $this->complainId;
    }

    /**
     * 投诉图片1
     * 
     * @return string
     */
    public function getComplainPic1()
    {
        return $this->complainPic1;
    }

    /**
     * 投诉图片2
     * 
     * @return string
     */
    public function getComplainPic2()
    {
        return $this->complainPic2;
    }

    /**
     * 投诉图片3
     * 
     * @return string
     */
    public function getComplainPic3()
    {
        return $this->complainPic3;
    }

    /**
     * 投诉状态【0-新投诉/1-投诉通过转给被投诉人/2-被投诉人已申诉/3-提交仲裁/4-已关闭】
     * 
     * @return int
     */
    public function getComplainState()
    {
        return $this->complainState;
    }

    /**
     * 最终处理时间
     * 
     * @return int
     */
    public function getFinalDatetime()
    {
        return $this->finalDatetime;
    }

    /**
     * 最终处理人【id】
     * 
     * @return int
     */
    public function getFinalId()
    {
        return $this->finalId;
    }

    /**
     * 最终处理意见
     * 
     * @return string
     */
    public function getFinalMessage()
    {
        return $this->finalMessage;
    }

    /**
     * 投诉处理时间
     * 
     * @return int
     */
    public function getHandleDatetime()
    {
        return $this->handleDatetime;
    }

    /**
     * 投诉处理人id
     * 
     * @return int
     */
    public function getHandleMemberId()
    {
        return $this->handleMemberId;
    }

    /**
     * 投诉id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 订单商品ID
     * 
     * @return int
     */
    public function getOrderGoodsId()
    {
        return $this->orderGoodsId;
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
