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

class StoreMsgTpl
{

    public static $id = 'id';
 // 主键
    public static $smtCode = 'smt_code';
 // 模板编码
    public static $smtName = 'smt_name';
 // 模板名称
    public static $smtMessage_switch = 'smt_message_switch';
 // 站内信默认开关【0关，1开】
    public static $smtMessage_content = 'smt_message_content';
 // 站内信内容
    public static $smtMessage_forced = 'smt_message_forced';
 // 站内信强制接收【0否，1是】
    public static $smtShort_switch = 'smt_short_switch';
 // 短信默认开关【0关，1开】
    public static $smtShort_content = 'smt_short_content';
 // 短信内容
    public static $smtShort_forced = 'smt_short_forced';
 // 短信强制接收【0否，1是】
    public static $smtMail_switch = 'smt_mail_switch';
 // 邮件默认开【0关，1开】
    public static $smtMail_subject = 'smt_mail_subject';
 // 邮件标题
    public static $smtMail_content = 'smt_mail_content';
 // 邮件内容
    public static $smtMail_forced = 'smt_mail_forced'; // 邮件强制接收【0否，1是】
}