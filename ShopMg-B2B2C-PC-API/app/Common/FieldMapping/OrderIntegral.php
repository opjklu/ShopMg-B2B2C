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

class OrderIntegral
{

    public static $id = 'id';
 // 编号
    public static $orderSn = 'order_sn';
 // 订单标志
    public static $interaglTotal = 'interagl_total';
 // 使用积分总数
    public static $priceSum = 'price_sum';
 // 花费金额
    public static $userId = 'user_id';
 // 用户
    public static $expressId = 'express_id';
 // 快递单编号
    public static $addressId = 'address_id';
 // 收货地址【编号】
    public static $createTime = 'create_time';
 // 创建时间
    public static $deliveryTime = 'delivery_time';
 // 发货时间
    public static $payTime = 'pay_time';
 // 支付时间
    public static $overTime = 'over_time';
 // 完结时间
    public static $orderStatus = 'order_status';
 // -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功,
    public static $commentStatus = 'comment_status';
 // 评价状态 0未评价 1已评价
    public static $wareId = 'ware_id';
 // 仓库编号
    public static $payType = 'pay_type';
 // 支付类型编号
    public static $remarks = 'remarks';
 // 订单备注
    public static $status = 'status';
 // 0正常1删除
    public static $translate = 'translate';
 // 1需要发票，0不需要
    public static $shippingMonery = 'shipping_monery';
 // 运费【这样 就不用 重复计算两遍】
    public static $expId = 'exp_id';
 // 快递表编号
    public static $platform = 'platform';
 // 平台【0代表pc，1代表app，2Wap, 3微商城】
    public static $orderType = 'order_type';
 // 订单类型【0普通订单1货到付款】
    public static $storeId = 'store_id'; // 店铺
}