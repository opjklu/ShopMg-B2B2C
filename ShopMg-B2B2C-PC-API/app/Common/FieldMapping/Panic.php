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

class Panic
{

    public static $id = 'id';
 // 抢购编号
    public static $panicTitle = 'panic_title';
 // 抢购标题
    public static $panicPrice = 'panic_price';
 // 抢购价格
    public static $goodsId = 'goods_id';
 // 商品编号
    public static $panicNum = 'panic_num';
 // 参加抢购数量
    public static $quantityLimit = 'quantity_limit';
 // 限购数量
    public static $alreadyNum = 'already_num';
 // 已购买
    public static $startTime = 'start_time';
 // 开始时间
    public static $endTime = 'end_time';
 // 结束时间
    public static $status = 'status';
 // 审核状态【0拒绝，1通过，2审核中】
    public static $storeId = 'store_id';
 // 店铺【编号】
    public static $createTime = 'create_time';
 // 创建时间
    public static $updateTime = 'update_time'; // 更新时间
}