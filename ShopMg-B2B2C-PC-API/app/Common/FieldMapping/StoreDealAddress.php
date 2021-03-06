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

class StoreDealAddress
{

    public static $id = 'id';
 // 编号
    public static $storeId = 'store_id';
 // 店铺编号
    public static $provId = 'prov_id';
 // 省份
    public static $cityId = 'city_id';
 // 市
    public static $distId = 'dist_id';
 // 区
    public static $address = 'address';
 // 详细地址
    public static $name = 'name';
 // 联系人
    public static $phone = 'phone';
 // 手机号码
    public static $email = 'email';
 // 邮箱
    public static $isDefault = 'is_default'; // 是否默认 1为默认 0为不默认
}