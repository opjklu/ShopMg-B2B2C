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

class CouponList
{

    public static $id = 'id';
 // 表id
    public static $cId = 'c_id';
 // 优惠券 对应coupon表id
    public static $type = 'type';
 // 发放类型 【0免费发放1 按用户发放 2 注册 3 邀请,4 线下发放，5 下单发放 】
    public static $userId = 'user_id';
 // 用户id
    public static $orderId = 'order_id';
 // 订单id
    public static $useTime = 'use_time';
 // 使用时间
    public static $code = 'code';
 // 优惠券兑换码
    public static $sendTime = 'send_time';
 // 发放时间
    public static $status = 'status'; // 0未使用1已使用
}