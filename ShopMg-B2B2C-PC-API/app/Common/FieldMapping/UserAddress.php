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

class UserAddress
{

    public static $id = 'id';
 // id
    public static $realname = 'realname';
 // 名字
    public static $mobile = 'mobile';
 // 手机号
    public static $userId = 'user_id';
 // user_id
    public static $createTime = 'create_time';
 // 创建时间
    public static $updateTime = 'update_time';
 // 更新时间
    public static $prov = 'prov';
 // 省
    public static $city = 'city';
 // 城市编号
    public static $dist = 'dist';
 // 区域编号
    public static $address = 'address';
 // 地址说
    public static $status = 'status';
 // 是否默认地址 默认 1 不默认 0
    public static $zipcode = 'zipcode';
 // 邮编
    public static $alias = 'alias';
 // 地址别名
    public static $email = 'email';
 // 电子邮件
    public static $telphone = 'telphone';
 // 座机
    public static $type = 'type'; // 地址类型【0 -收货地址，1-公司地址（店铺地址），2-开户行地址，3-结算账号开户行地址，4- 实体店地址
}