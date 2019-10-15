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
use App\Models\Logic\Specific\AlipaySerialNumberLogic;

class AlipaySerialNumber
{

    /**
     * 商品支付相关
     *
     * @param unknown $param
     */
    public function aplipaySerial(&$param)
    {
        $status = App::getBean(AlipaySerialNumberLogic::class)->parseAlipayConfig($param);

        $param = !$status ? [] : $param;
    }

    /**
     * 余额支付
     *
     * @param unknown $param
     */
    public function aplipayBalanceSerial(&$param)
    {
        $status = App::getBean(AlipaySerialNumberLogic::class)->parseByPay($param);

        $param = !$status ? [] : $param;
    }
}