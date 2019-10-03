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

class OrderPackageReturnGoods
{

    public static $id = 'id';
 // 退货id
    public static $orderId = 'order_id';
 // 订单【id】
    public static $tuihuoCase = 'tuihuo_case';
 // 退货理由
    public static $createTime = 'create_time';
 // 申请时间
    public static $revocationTime = 'revocation_time';
 // 撤销时间
    public static $updateTime = 'update_time';
 // 审核时间
    public static $goodsId = 'goods_id';
 // 退货的商品【id】
    public static $explain = 'explain';
 // 退货(退款)说明
    public static $price = 'price';
 // 退货金额
    public static $isReceive = 'is_receive';
 // 退款及其换货时是否收到货【0未收到1收到】
    public static $status = 'status';
 // 审核状态【0审核中1审核失败2审核通过3退货中4退货完成 5已撤销 】
    public static $userId = 'user_id';
 // 用户编号
    public static $number = 'number';
 // 申请数量
    public static $applyImg = 'apply_img';
 // 申请图片
    public static $content = 'content';
 // 审核内容
    public static $isOwn = 'is_own';
 // 是否自营【0否 1是】
    public static $expressId = 'express_id';
 // 快递【编号】
    public static $waybillId = 'waybill_id';
 // 运单号
    public static $remark = 'remark';
 // 备注
    public static $storeId = 'store_id';
 // 店铺【编号】
    public static $applyId = 'apply_id'; // 审核人
}