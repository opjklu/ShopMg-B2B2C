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

class Goods
{

    public static $id = 'id';
 // 主键编号
    public static $brandId = 'brand_id';
 // 品牌【编号】
    public static $title = 'title';
 // 商品标题
    public static $priceMarket = 'price_market';
 // 市场价
    public static $priceMember = 'price_member';
 // 会员价
    public static $stock = 'stock';
 // 库存
    public static $selling = 'selling';
 // 是否是热销 0 不是 1 是
    public static $shelves = 'shelves';
 // 是否上架【0下架，1表示选择上架】
    public static $classId = 'class_id';
 // 商品分类ID
    public static $recommend = 'recommend';
 // 是否推荐【1推荐 0不推荐】
    public static $code = 'code';
 // 商品货号
    public static $top = 'top';
 // 顶部推荐
    public static $seasonHot = 'season_hot';
 // 当季热卖
    public static $description = 'description';
 // 商品简介
    public static $updateTime = 'update_time';
 // 最后一次编辑时间
    public static $createTime = 'create_time';
 // 创建时间
    public static $goodsType = 'goods_type';
 // 商品类型
    public static $sort = 'sort';
 // 排序
    public static $pId = 'p_id';
 // 父级产品 SPU
    public static $status = 'status';
 // 促销活动【0没有活动，1尾货清仓，3积分商城,5抢购, 6团购】
    public static $commentMember = 'comment_member';
 // 评论次数
    public static $salesSum = 'sales_sum';
 // 商品销量
    public static $attrType = 'attr_type';
 // 商品属性编号【为goods_type表中数据】
    public static $extend = 'extend';
 // 扩展分类
    public static $advanceDate = 'advance_date';
 // 预售日期
    public static $weight = 'weight';
 // 重量
    public static $storeId = 'store_id';
 // 店铺【编号】
    public static $type = 'type';
 // 店铺商品类型【0个人，1公司，2自营】
    public static $approvalStatus = 'approval_status';
 // 审核状态【0未审核， 1审核通过， 2审核失败】
    public static $classTwo = 'class_two';
 // 二级分类【编号】
    public static $classThree = 'class_three';
 // 三级分类【编号】
    public static $expressId = 'express_id'; // 运费模板编号
}