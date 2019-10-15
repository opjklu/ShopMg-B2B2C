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

class Complain
{

    public static $id = 'id';
 // 投诉id
    public static $orderId = 'order_id';
 // 订单id
    public static $orderGoods_id = 'order_goods_id';
 // 订单商品ID
    public static $accuserId = 'accuser_id';
 // 原告id
    public static $accusedId = 'accused_id';
 // 被告id
    public static $complainId = 'complain_id';
 // 投诉主题id
    public static $complainContent = 'complain_content';
 // 投诉内容
    public static $complainPic1 = 'complain_pic1';
 // 投诉图片1
    public static $complainPic2 = 'complain_pic2';
 // 投诉图片2
    public static $complainPic3 = 'complain_pic3';
 // 投诉图片3
    public static $complainDatetime = 'complain_datetime';
 // 投诉时间
    public static $handleDatetime = 'handle_datetime';
 // 投诉处理时间
    public static $handleMember_id = 'handle_member_id';
 // 投诉处理人id
    public static $appealMessage = 'appeal_message';
 // 申诉内容
    public static $appealDatetime = 'appeal_datetime';
 // 申诉时间
    public static $appealPic1 = 'appeal_pic1';
 // 申诉图片1
    public static $appealPic2 = 'appeal_pic2';
 // 申诉图片2
    public static $appealPic3 = 'appeal_pic3';
 // 申诉图片3
    public static $finalMessage = 'final_message';
 // 最终处理意见
    public static $finalDatetime = 'final_datetime';
 // 最终处理时间
    public static $finalId = 'final_id';
 // 最终处理人【id】
    public static $complainState = 'complain_state';
 // 投诉状态【0-新投诉/1-投诉通过转给被投诉人/2-被投诉人已申诉/3-提交仲裁/4-已关闭】
    public static $complainActive = 'complain_active'; // 投诉是否通过平台审批【0未通过/1通过】
}