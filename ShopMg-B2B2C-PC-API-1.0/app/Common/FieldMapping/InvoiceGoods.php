<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 米糕网络团队<13052079525> All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队<13052079525>
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
namespace App\Common\FieldMapping;

class InvoiceGoods
{

    public static $id = 'id';
 // 主键id
    public static $goodsId = 'goods_id';
 // 商品编号
    public static $goodsCompany = 'goods_company';
 // 单位
    public static $goodsNum = 'goods_num';
 // 数量
    public static $goodsPrice = 'goods_price';
 // 单价(含税)
    public static $goodsPrice_num = 'goods_price_num';
 // 金额(含税)
    public static $goodsTax_rate = 'goods_tax_rate';
 // 税率
    public static $goodsTax = 'goods_tax';
 // 税额
    public static $goodsPay_type = 'goods_pay_type';
 // 付款方式
    public static $goodsDue_date = 'goods_due_date';
 // 到期日
    public static $goodsRemarks = 'goods_remarks';
 // 备注
    public static $goodsOrder_id = 'goods_order_id';
 // 订单id
    public static $addTime = 'add_time';
 // 添加时间
    public static $editTime = 'edit_time';
 // 修改时间
    public static $invoiceId = 'invoice_id'; // 发票id
}