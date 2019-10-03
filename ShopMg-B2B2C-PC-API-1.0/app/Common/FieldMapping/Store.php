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

class Store
{

    public static $id = 'id';
 // 主键编号
    public static $shopName = 'shop_name';
 // 店铺名称
    public static $classId = 'class_id';
 // 店铺分类【编号】
    public static $gradeId = 'grade_id';
 // 店铺等级
    public static $storeAddress = 'store_address';
 // 地址编号
    public static $userId = 'user_id';
 // 店主【编号】
    public static $storeState = 'store_state';
 // 店铺状态【0关闭，1开启，2审核中】
    public static $storeSort = 'store_sort';
 // 店铺排序
    public static $startTime = 'start_time';
 // 店铺营业开始时间
    public static $endTime = 'end_time';
 // 店铺营业结束时间
    public static $status = 'status';
 // 推荐【0为否，1为是，默认为0】
    public static $themeId = 'theme_id';
 // 店铺当前主题
    public static $storeCollect = 'store_collect';
 // 店铺收藏数量
    public static $printDesc = 'print_desc';
 // 打印订单页面下方说明文字
    public static $storeSales = 'store_sales';
 // 店铺销量
    public static $freePrice = 'free_price';
 // 超出该金额免运费【大于0才表示该值有效】
    public static $decorationSwitch = 'decoration_switch';
 // 店铺装修开关【0-关闭 装修编号-开启】
    public static $decorationOnly = 'decoration_only';
 // 开启店铺装修【仅显示店铺装修(1-是 0-否】
    public static $imageCount = 'image_count';
 // 店铺装修相册图片数量
    public static $isOwn = 'is_own';
 // 是否自营店铺 【1是 0否】
    public static $buildAll = 'build_all';
 // 自营店是否绑定全部分类【 0否1是】
    public static $barType = 'bar_type';
 // 店铺商品页面左侧显示类型【 0默认1商城相关分类品牌商品推荐】
    public static $isDistribution = 'is_distribution';
 // 是否分销店铺【0-否，1-是】
    public static $createTime = 'create_time';
 // 创建时间
    public static $updateTime = 'update_time';
 // 更新时间
    public static $type = 'type';
 // 店铺类型【0个人入驻 1企业入驻】
    public static $storeLogo = 'store_logo';
 // 店铺logo
    public static $commission = 'commission';
 // 佣金比例【0-100】
    public static $description = 'description';
 // 描述
    public static $wxAccout = 'wx_accout';
 // 微信账号
    public static $alipayAccount = 'alipay_account';
 // 支付宝账号
    public static $bankAccount = 'bank_account';
 // 银行卡号
    public static $credibility = 'credibility';
 // 信誉
    public static $mobile = 'mobile';
 // 联系方式
    public static $personName = 'person_name';
 // 联系人姓名
    public static $shopLong = 'shop_long'; // 开店时长
}