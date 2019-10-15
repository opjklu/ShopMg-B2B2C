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

class Group
{

    public static $id = 'id';
 // 团购ID
    public static $title = 'title';
 // 活动名称
    public static $startTime = 'start_time';
 // 开始时间
    public static $endTime = 'end_time';
 // 结束时间
    public static $goodsId = 'goods_id';
 // 商品ID
    public static $price = 'price';
 // 团购价格
    public static $goodsNum = 'goods_num';
 // 商品参团数
    public static $buyNum = 'buy_num';
 // 商品已购买数
    public static $orderNum = 'order_num';
 // 已下单人数
    public static $virtualNum = 'virtual_num';
 // 虚拟购买数
    public static $description = 'description';
 // 本团介绍
    public static $recommended = 'recommended';
 // 是否推荐 0.未推荐 1.已推荐
    public static $lookNum = 'look_num';
 // 查看次数
    public static $updateTime = 'update_time';
 // 更新时间
    public static $createTime = 'create_time';
 // 添加时间
    public static $storeId = 'store_id';
 // 店铺id
    public static $auditingStatus = 'auditing_status'; // 审核状态【 0拒绝 1为已审核，2审核中】
}