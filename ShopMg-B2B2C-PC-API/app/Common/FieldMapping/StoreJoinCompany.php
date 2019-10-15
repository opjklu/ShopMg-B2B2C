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

class StoreJoinCompany
{

    public static $id = 'id';
 // 主键编号
    public static $userId = 'user_id';
 // 申请人
    public static $storeName = 'store_name';
 // 店铺名称
    public static $companyName = 'company_name';
 // 公司名称
    public static $numberEmployees = 'number_employees';
 // 员工数
    public static $registeredCapital = 'registered_capital';
 // 注册资金数
    public static $licenseNumber = 'license_number';
 // 营业执照号
    public static $validityStart = 'validity_start';
 // 营业执照开始日期
    public static $validityEnd = 'validity_end';
 // 营业执照结束日期
    public static $electronicVersion = 'electronic_version';
 // 营业执照电子版
    public static $organizationCode = 'organization_code';
 // 组织机构代码
    public static $organizationElectronic = 'organization_electronic';
 // 组织机构代码证电子版
    public static $taxpayerCertificate = 'taxpayer_certificate';
 // 一般纳税人证明
    public static $createTime = 'create_time';
 // 创建时间
    public static $updateTime = 'update_time';
 // 更新时间
    public static $status = 'status';
 // 申请状态 【0-已提交申请 1-缴费完成 2-审核成功 3-审核失败 4-缴费审核失败 5-审核通过开店】
    public static $remark = 'remark';
 // 备注
    public static $mobile = 'mobile';
 // 联系人手机
    public static $companyMobile = 'company_mobile';
 // 公司电话
    public static $name = 'name';
 // 联系人姓名
    public static $scopeOf_operation = 'scope_of_operation'; // 法定经营范围
}