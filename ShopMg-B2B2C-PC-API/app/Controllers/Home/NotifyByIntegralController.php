<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Common\TraitClass\GETConfigTrait;
use App\Common\TraitClass\NotifyTrait;
use App\Common\TraitClass\OrderNoticeTrait;
use Swoft\Http\Server\Bean\Annotation\Controller;

/**
 * @Controller()
 * 积分支付通知
 *
 * @author Administrator
 */
class NotifyByIntegralController
{
    use NotifyTrait;

    use GETConfigTrait;

    use OrderNoticeTrait;

    /**
     * 积分支付
     *
     * @var integer
     */
    const IntegralToPay = 2;

    public function __construct()
    {
        $this->orderType = static::IntegralToPay;
    }
}