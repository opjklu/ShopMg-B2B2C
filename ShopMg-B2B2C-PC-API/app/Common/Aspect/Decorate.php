<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 wq.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://wq.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
namespace App\Common\Aspect;

use Swoft\App;
use App\Models\Logic\Specific\OrderWxpayLogic;

class Decorate
{

    public function aplipaySerial(&$param)
    {
        // 更改订单微信表
        $status = App::getBean(OrderWxpayLogic::class)->nofityUpdate($param);

        if (!$status) {
            $param = [];
        }
    }

    public function aplipayBalanceSerial(&$param)
    {

        // 更改订单微信表
        $status = App::getBean(OrderWxpayLogic::class)->nofityUpdateBySpecial($param);

        if (empty($status)) {
            $param = [];
        }
    }
}