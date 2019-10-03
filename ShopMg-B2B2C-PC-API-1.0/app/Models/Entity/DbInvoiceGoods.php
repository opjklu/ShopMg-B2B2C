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
 * 发票商品表
 *
 * @Entity()
 * @Table(name="mg_invoice_goods")
 * 
 * @uses DbInvoiceGoods
 */
class DbInvoiceGoods extends Model
{

    /**
     *
     * @var int $addTime 添加时间
     *      @Column(name="add_time", type="integer")
     */
    private $addTime;

    /**
     *
     * @var int $editTime 修改时间
     *      @Column(name="edit_time", type="integer")
     */
    private $editTime;

    /**
     *
     * @var string $goodsCompany 单位
     *      @Column(name="goods_company", type="string", length=20)
     */
    private $goodsCompany;

    /**
     *
     * @var int $goodsDueDate 到期日
     *      @Column(name="goods_due_date", type="integer")
     */
    private $goodsDueDate;

    /**
     *
     * @var int $goodsId 商品编号
     *      @Column(name="goods_id", type="integer")
     */
    private $goodsId;

    /**
     *
     * @var int $goodsNum 数量
     *      @Column(name="goods_num", type="integer")
     */
    private $goodsNum;

    /**
     *
     * @var int $goodsOrderId 订单id
     *      @Column(name="goods_order_id", type="integer")
     */
    private $goodsOrderId;

    /**
     *
     * @var string $goodsPayType 付款方式
     *      @Column(name="goods_pay_type", type="char", length=50)
     */
    private $goodsPayType;

    /**
     *
     * @var float $goodsPrice 单价(含税)
     *      @Column(name="goods_price", type="float")
     */
    private $goodsPrice;

    /**
     *
     * @var float $goodsPriceNum 金额(含税)
     *      @Column(name="goods_price_num", type="float")
     */
    private $goodsPriceNum;

    /**
     *
     * @var string $goodsRemarks 备注
     *      @Column(name="goods_remarks", type="string", length=50)
     */
    private $goodsRemarks;

    /**
     *
     * @var float $goodsTax 税额
     *      @Column(name="goods_tax", type="float")
     */
    private $goodsTax;

    /**
     *
     * @var string $goodsTaxRate 税率
     *      @Column(name="goods_tax_rate", type="char", length=50)
     */
    private $goodsTaxRate;

    /**
     *
     * @var int $id 主键id
     *      @Id()
     *      @Column(name="id", type="integer")
     */
    private $id;

    /**
     *
     * @var int $invoiceId 发票id
     *      @Column(name="invoice_id", type="integer")
     */
    private $invoiceId;

    /**
     * 添加时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setAddTime(int $value): self
    {
        $this->addTime = $value;
        
        return $this;
    }

    /**
     * 修改时间
     * 
     * @param int $value            
     * @return $this
     */
    public function setEditTime(int $value): self
    {
        $this->editTime = $value;
        
        return $this;
    }

    /**
     * 单位
     * 
     * @param string $value            
     * @return $this
     */
    public function setGoodsCompany(string $value): self
    {
        $this->goodsCompany = $value;
        
        return $this;
    }

    /**
     * 到期日
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsDueDate(int $value): self
    {
        $this->goodsDueDate = $value;
        
        return $this;
    }

    /**
     * 商品编号
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
     * 数量
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsNum(int $value): self
    {
        $this->goodsNum = $value;
        
        return $this;
    }

    /**
     * 订单id
     * 
     * @param int $value            
     * @return $this
     */
    public function setGoodsOrderId(int $value): self
    {
        $this->goodsOrderId = $value;
        
        return $this;
    }

    /**
     * 付款方式
     * 
     * @param string $value            
     * @return $this
     */
    public function setGoodsPayType(string $value): self
    {
        $this->goodsPayType = $value;
        
        return $this;
    }

    /**
     * 单价(含税)
     * 
     * @param float $value            
     * @return $this
     */
    public function setGoodsPrice(float $value): self
    {
        $this->goodsPrice = $value;
        
        return $this;
    }

    /**
     * 金额(含税)
     * 
     * @param float $value            
     * @return $this
     */
    public function setGoodsPriceNum(float $value): self
    {
        $this->goodsPriceNum = $value;
        
        return $this;
    }

    /**
     * 备注
     * 
     * @param string $value            
     * @return $this
     */
    public function setGoodsRemarks(string $value): self
    {
        $this->goodsRemarks = $value;
        
        return $this;
    }

    /**
     * 税额
     * 
     * @param float $value            
     * @return $this
     */
    public function setGoodsTax(float $value): self
    {
        $this->goodsTax = $value;
        
        return $this;
    }

    /**
     * 税率
     * 
     * @param string $value            
     * @return $this
     */
    public function setGoodsTaxRate(string $value): self
    {
        $this->goodsTaxRate = $value;
        
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
     * 发票id
     * 
     * @param int $value            
     * @return $this
     */
    public function setInvoiceId(int $value): self
    {
        $this->invoiceId = $value;
        
        return $this;
    }

    /**
     * 添加时间
     * 
     * @return int
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * 修改时间
     * 
     * @return int
     */
    public function getEditTime()
    {
        return $this->editTime;
    }

    /**
     * 单位
     * 
     * @return string
     */
    public function getGoodsCompany()
    {
        return $this->goodsCompany;
    }

    /**
     * 到期日
     * 
     * @return int
     */
    public function getGoodsDueDate()
    {
        return $this->goodsDueDate;
    }

    /**
     * 商品编号
     * 
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * 数量
     * 
     * @return int
     */
    public function getGoodsNum()
    {
        return $this->goodsNum;
    }

    /**
     * 订单id
     * 
     * @return int
     */
    public function getGoodsOrderId()
    {
        return $this->goodsOrderId;
    }

    /**
     * 付款方式
     * 
     * @return string
     */
    public function getGoodsPayType()
    {
        return $this->goodsPayType;
    }

    /**
     * 单价(含税)
     * 
     * @return float
     */
    public function getGoodsPrice()
    {
        return $this->goodsPrice;
    }

    /**
     * 金额(含税)
     * 
     * @return float
     */
    public function getGoodsPriceNum()
    {
        return $this->goodsPriceNum;
    }

    /**
     * 备注
     * 
     * @return string
     */
    public function getGoodsRemarks()
    {
        return $this->goodsRemarks;
    }

    /**
     * 税额
     * 
     * @return float
     */
    public function getGoodsTax()
    {
        return $this->goodsTax;
    }

    /**
     * 税率
     * 
     * @return string
     */
    public function getGoodsTaxRate()
    {
        return $this->goodsTaxRate;
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
     * 发票id
     * 
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }
}
