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

class SendAddress
{

    public static $id = 'id';
 // 运送编号
    public static $prov = 'prov';
 // 省
    public static $addressDetail = 'address_detail';
 // 详细地址
    public static $createTime = 'create_time';
 // 创建时间
    public static $updateTime = 'update_time';
 // 更新时间
    public static $status = 'status';
 // 是否启用[0启用1不启用]
    public static $stockName = 'stock_name';
 // 仓库名称
    public static $def = 'def';
 // 是否默认[0不默认1默认]
    public static $city = 'city';
 // 市
    public static $dist = 'dist';
 // 县
    public static $storeId = 'store_id'; // 店铺id
}