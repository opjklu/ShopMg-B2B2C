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
 * 退货表
 *
 * @Entity()
 * @Table(name="mg_order_return_goods")
 * 
 * @uses DbOrderReturnGoods
 */
class DbOrderReturnGoods extends Model
{

    /**
     *
     * @var int $applyId 审核人
     *      @Column(name="apply_id", type="integer")
     *      @Required()
     */
    private $applyId;

    /**
     *
     * @var string $applyImg 申请图片
     *      @Column(name="apply_img", type="string", length=255)
     */
    private $applyImg;

    /**
     *
     * @var string $content 审核内容
     *      @Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     *
     * @var int $createTime 申请时间
     *      @Column(name="create_time", type="integer", default=0)
     */
    private $createTime;

    /**
     *
     * @var string $explain 退货(退款)说明
     *      @Column(name="explain", type="string", length=300)
     */
    private $explain;

    /**
     *
     * @var int $expressId 快递【编号】
     *      @Column(name="express_id", type="integer", default=1)
     */
    private $expressId;

    /**
     *
     * @var int $goodsId 退货的商品【id】
     *      @Column(name="goods_id", type="integer")
     *      @Required()
     */
    private $goodsId;

    /**
     *
     * @var int $id 退货id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $isOwn 是否自营【0否 1是】
     *      @Column(name="is_own", type="tinyint", default=0)
     */
    private $isOwn;

    /**
     *
     * @var int $isReceive 退款及其换货时是否收到货【0未收到1收到】
     *      @Column(name="is_receive", type="tinyint", default=0)
     */
    private $isReceive;

    /**
     *
     * @var int $number 申请数量
     *      @Column(name="number", type="integer", default=0)
     */
    private $number;

    /**
     *
     * @var int $orderId 订单【id】
     *      @Column(name="order_id", type="integer", default=0)
     */
    private $orderId;

    /**
     *
     * @var float $price 退货金额
     *      @Column(name="price", type="float", default=0)
     */
    private $price;

    /**
     *
     * @var string $remark 备注
     *      @Column(name="remark", type="string", length=80)
     */
    private $remark;

    /**
     *
     * @var int $revocationTime 撤销时间
     *      @Column(name="revocation_time", type="integer", default=0)
     */
    private $revocationTime;

    /**
     *
     * @var int $status 审核状态【0审核中1审核失败2审核通过3退货中4退货完成 5已撤销 】
     *      @Column(name="status", type="tinyint", default=0)
     */
    private $status;

    /**
     *
     * @var int $storeId 店铺【编号】
     *      @Column(name="store_id", type="integer")
     *      @Required()
     */
    private $storeId;

    /**
     *
     * @var string $tuihuoCase 退货理由
     *      @Column(name="tuihuo_case", type="string", length=50, default="")
     */
    private $tuihuoCase;

    /**
     *
     * @var int $updateTime 审核时间
     *      @Column(name="update_time", type="integer", default=0)
     */
    private $updateTime;

    /**
     *
     * @var int $userId 用户编号
     *      @Column(name="user_id", type="integer", default=0)
     */
    private $userId;

    /**
     *
     * @var int $waybillId 运单号
     *      @Column(name="waybill_id", type="bigint")
     */
    private $waybillId;

    /**
     * 审核人
     * 
     * @param int $value            
     * @return $this
     */
    public function setApplyId(int $value): self
    {
        $this->applyId = $value;
        
        return $this;
    }

    /**
     * 申请图片
     * 
     * @param string $value            
     * @return $this
     */
    public function setApplyImg(string $value): self
    {
        $this->applyImg = $value;
        
        return $this;
    }

    /**
     * 审核内容
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
     * 申请时间
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
     * 退货(退款)说明
     * 
     * @param string $value            
     * @return $this
     */
    public function setExplain(string $value): self
    {
        $this->explain = $value;
        
        return $this;
    }

    /**
     * 快递【编号】
     * 
     * @param int $value            
     * @return $this
     */
    public function setExpressId(int $value): self
    {
        $this->expressId = $value;
        
        return $this;
    }

    /**
     * 退货的商品【id】
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsId(int $value): self
    {
        $this->goodsId = $value;
        
        return $this;
    }

    /**
     * 退货id
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
     * 是否自营【0否 1是】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsOwn(int $value): self
    {
        $this->isOwn = $value;
        
        return $this;
    }

    /**
     * 退款及其换货时是否收到货【0未收到1收到】
     * 
     * @param int $value            
     * @return $this
     */
    public function setIsReceive(int $value): self
    {
        $this->isReceive = $value;
        
        return $this;
    }

    /**
     * 申请数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setNumber(int $value): self
    {
        $this->number = $value;
        
        return $this;
    }

    /**
     * 订单【id】
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
     * 退货金额
     * 
     * @param float $value            
     * @return $this
     */
    public function setPrice(float $value): self
    {
        $this->price = $value;
        
        return $this;
    }

    /**
     * 备注
     * 
     * @param string $value            
     * @return $this
     */
    public function setRemark(string $value): self
    {
        $this->remark = $value;
        
        return $this;
    }

    /**
     * 撤销时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setRevocationTime(int $value): self
    {
        $this->revocationTime = $value;
        
        return $this;
    }

    /**
     * 审核状态【0审核中1审核失败2审核通过3退货中4退货完成 5已撤销 】
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
     * 店铺【编号】
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
     * 退货理由
     * 
     * @param string $value            
     * @return $this
     */
    public function setTuihuoCase(string $value): self
    {
        $this->tuihuoCase = $value;
        
        return $this;
    }

    /**
     * 审核时间
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
     * 运单号
     * 
     * @param int $value            
     * @return $this
     */
    public function setWaybillId(int $value): self
    {
        $this->waybillId = $value;
        
        return $this;
    }

    /**
     * 审核人
     * 
     * @return int
     */
    public function getApplyId()
    {
        return $this->applyId;
    }

    /**
     * 申请图片
     * 
     * @return string
     */
    public function getApplyImg()
    {
        return $this->applyImg;
    }

    /**
     * 审核内容
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 申请时间
     * 
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * 退货(退款)说明
     * 
     * @return string
     */
    public function getExplain()
    {
        return $this->explain;
    }

    /**
     * 快递【编号】
     * 
     * @return mixed
     */
    public function getExpressId()
    {
        return $this->expressId;
    }

    /**
     * 退货的商品【id】
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 退货id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 是否自营【0否 1是】
     * 
     * @return int
     */
    public function getIsOwn()
    {
        return $this->isOwn;
    }

    /**
     * 退款及其换货时是否收到货【0未收到1收到】
     * 
     * @return int
     */
    public function getIsReceive()
    {
        return $this->isReceive;
    }

    /**
     * 申请数量
     * 
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * 订单【id】
     * 
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 退货金额
     * 
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * 备注
     * 
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * 撤销时间
     * 
     * @return int
     */
    public function getRevocationTime()
    {
        return $this->revocationTime;
    }

    /**
     * 审核状态【0审核中1审核失败2审核通过3退货中4退货完成 5已撤销 】
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 店铺【编号】
     * 
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * 退货理由
     * 
     * @return string
     */
    public function getTuihuoCase()
    {
        return $this->tuihuoCase;
    }

    /**
     * 审核时间
     * 
     * @return int
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
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

    /**
     * 运单号
     * 
     * @return int
     */
    public function getWaybillId()
    {
        return $this->waybillId;
    }
}
