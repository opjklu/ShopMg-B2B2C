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

class StoreCompanyBankInformation
{

    public static $id = 'id';
 // 编号
    public static $storeId = 'store_id';
 // 店铺【编号】
    public static $accountName = 'account_name';
 // 开户名
    public static $companyAccount = 'company_account';
 // 公司银行账号
    public static $branchBank = 'branch_bank';
 // 开户银行支行名称
    public static $branchNumber = 'branch_number';
 // 支行联行号
    public static $bankElectronic = 'bank_electronic';
 // 开户银行许可证电子版
    public static $isSettle = 'is_settle';
 // 是否以开户行作为结算账号 0-否 1-是
    public static $settleName = 'settle_name';
 // 结算账户开户名
    public static $settleAccount = 'settle_account';
 // 结算公司银行账号
    public static $settleBank = 'settle_bank';
 // 结算开户银行支行名称
    public static $settleNumber = 'settle_number';
 // 结算支行联行号
    public static $certificateNumber = 'certificate_number';
 // 税务登记证号
    public static $identificationNumber = 'identification_number';
 // 纳税人识别号
    public static $registrationElectronic = 'registration_electronic';
 // 税务登记证号电子版
    public static $alipayAccount = 'alipay_account';
 // 支付宝支付账号
    public static $wxAccount = 'wx_account';
 // 微信支付账号
    public static $createTime = 'create_time';
 // 添加时间
    public static $updateTime = 'update_time'; // 更新时间
}