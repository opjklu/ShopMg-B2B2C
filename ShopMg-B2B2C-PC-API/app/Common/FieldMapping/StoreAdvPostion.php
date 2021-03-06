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

class StoreAdvPostion
{

    public static $id = 'id';
 // 广告位置id
    public static $apName = 'ap_name';
 // 广告位置名
    public static $apClass = 'ap_class';
 // 广告类别【0图片1文字2幻灯3Flash】
    public static $apDisplay = 'ap_display';
 // 广告展示方式：0幻灯片1多广告展示2单广告展示
    public static $isUse = 'is_use';
 // 广告位是否启用：0不启用1启用
    public static $apWidth = 'ap_width';
 // 广告位宽度
    public static $apHeight = 'ap_height';
 // 广告位高度
    public static $advNum = 'adv_num';
 // 拥有的广告数
    public static $clickNum = 'click_num';
 // 广告位点击率
    public static $defaultContent = 'default_content';
 // 广告位默认内容
    public static $maxHeight = 'max_height';
 // 最小高度
    public static $maxWidth = 'max_width';
 // 最大宽度
    public static $createTime = 'create_time';
 // 添加时间
    public static $updateTime = 'update_time'; // 更新时间
}