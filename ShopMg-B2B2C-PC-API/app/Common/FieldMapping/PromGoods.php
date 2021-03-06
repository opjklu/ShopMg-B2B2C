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

class PromGoods
{

    public static $id = 'id';
 // 活动ID
    public static $name = 'name';
 // 促销活动名称
    public static $type = 'type';
 // 促销类型
    public static $expression = 'expression';
 // 优惠体现
    public static $description = 'description';
 // 活动描述
    public static $startTime = 'start_time';
 // 活动开始时间
    public static $endTime = 'end_time';
 // 活动结束时间
    public static $status = 'status';
 // 活动状态 1 开启 0 关闭
    public static $group = 'group';
 // 适用范围
    public static $promImg = 'prom_img';
 // 活动宣传图片
    public static $createTime = 'create_time';
 // 创建时间
    public static $updateTime = 'update_time';
 // 更新时间
    public static $storeId = 'store_id';
 // 店铺id
    public static $full = 'full';
 // 满多少
    public static $panicBuy = 'panic_buy';
 // 抢购数量
    public static $limitBuy = 'limit_buy'; // 限购数量
}