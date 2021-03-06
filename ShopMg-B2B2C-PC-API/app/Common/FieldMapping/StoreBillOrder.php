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

class StoreBillOrder
{

    public static $id = 'id';
 // 打款编号
    public static $widbatchNo = 'widbatch_no';
 // 打款批次号
    public static $widbatchFee = 'widbatch_fee';
 // 打款总金额
    public static $widbatchNum = 'widbatch_num';
 // 付款笔数
    public static $widdetailDescription = 'widdetail_description';
 // 付款描述
    public static $adminId = 'admin_id';
 // 操作人
    public static $createTime = 'create_time';
 // 创建时间
    public static $updateTime = 'update_time'; // 更新时间
}