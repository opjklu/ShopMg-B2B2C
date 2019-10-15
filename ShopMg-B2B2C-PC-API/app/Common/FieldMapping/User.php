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

class User
{

    public static $id = 'id';
 // 用户编号
    public static $mobile = 'mobile';
 // 电话号码
    public static $createTime = 'create_time';
 // 创建时间
    public static $status = 'status';
 // 账号状态【1正常 0禁用】
    public static $updateTime = 'update_time';
 // 更新时间
    public static $openId = 'open_id';
 // openid是公众号的普通用户的一个唯一的标识
    public static $password = 'password';
 // 密码
    public static $userName = 'user_name';
 // 用户名
    public static $nickName = 'nick_name';
 // 昵称
    public static $birthday = 'birthday';
 // 生日
    public static $idCard = 'id_card';
 // 身份证号码
    public static $email = 'email';
 // 邮箱
    public static $sex = 'sex';
 // 性别【0女，1男】
    public static $lastLogon_time = 'last_logon_time';
 // 上次登录时间
    public static $salt = 'salt';
 // 加盐字段【： 和密码进行加密，增加密码强度】
    public static $recommendcode = 'recommendcode';
 // 推荐人编码
    public static $validateEmail = 'validate_email';
 // 是否验证邮箱【0没有， 1已验证】
    public static $memberDiscount = 'member_discount';
 // 折扣率
    public static $pId = 'p_id'; // 父级会员编号
}