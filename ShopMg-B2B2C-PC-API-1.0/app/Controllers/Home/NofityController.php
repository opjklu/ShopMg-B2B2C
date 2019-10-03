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
 * @Controller(perfix="/nofity")
 * 商品支付通知
 *
 * @author Administrator
 */
class NofityController
{
    use GETConfigTrait;

    use OrderNoticeTrait;

    use NotifyTrait;

    /**
     * 普通支付
     *
     * @var integer
     */
    const GeneralMerchandisePayment = 0;

    public function __construct()
    {
        $this->orderType = static::GeneralMerchandisePayment;
    }
}