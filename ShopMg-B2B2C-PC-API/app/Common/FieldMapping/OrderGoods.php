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

class OrderGoods
{

    public static $id = 'id';
 // id
    public static $orderId = 'order_id';
 // 商品id
    public static $goodsId = 'goods_id';
 // 商品编号
    public static $goodsNum = 'goods_num';
 // 商品数量
    public static $goodsPrice = 'goods_price';
 // 商品价格
    public static $status = 'status';
 // -1：取消订单；0 未支付，1已支付，2，发货中，3已发货，4已收货，5退货审核中，6审核失败，7审核成功，8退款中，9退款成功, 10退货商家收货中，11退货商家已收货，12换货审核中
    public static $spaceId = 'space_id';
 // 商品规格id
    public static $userId = 'user_id';
 // 用户id
    public static $comment = 'comment';
 // 是否已评价（0未评价1已评价）
    public static $over = 'over';
 // 是否已完成该单(0未完成 1已完成）
    public static $wareId = 'ware_id';
 // 所在仓库
    public static $storeId = 'store_id';
 // 店铺【编号】
    public static $freightId = 'freight_id'; // 模板【编号】
}