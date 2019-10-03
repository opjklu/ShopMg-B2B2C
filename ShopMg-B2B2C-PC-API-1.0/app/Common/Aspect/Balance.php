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

/**
 * 余额支付行为
 *
 * @author Administrator
 */
class Balance
{

    public function aplipaySerial(&$param)
    {
        return $param;
    }

    public function aplipayBalanceSerial(& $param)
    {
    }
}