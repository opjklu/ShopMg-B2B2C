<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 wq.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://wq.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！让外表简单一点，内涵就会更丰富一点。
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
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\DispatcherPayTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\PayLogic;
use App\Models\Logic\Specific\RechargeLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 余额充值
 * @Controller(perfix="recharge")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class RechargeController
{

    use DispatcherPayTrait;

    /**
     * @Inject()
     *
     * @var PayLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var RechargeLogic
     */
    private $rechargeLogic;

    /**
     * 支付类型处理
     *
     * @var array
     */
    private $payName = [
        'Pay\\BalanceRechargeByWxPay',
        'Pay\\BalanceRechargeByAlipay',
        'Pay\\BalanceRechargeUnionPay',
        ''
    ];

    /**
     * 通知控制器及其action
     *
     * @var array
     */
    private $notifyURL = [
        '/rechargeNofity/rechargeWxNotify',
        '/rechargeNofity/aplipayRechargeNofity',
        '/rechargeNofity/unionNotify',
        ''
    ];

    /**
     *
     * @var string
     */
    private $reuturnURL = [
        '/RechargeNofity/rechargeWxNotify',
        '/rechargeSuccess',
        '/unionNotify',
        ''
    ];

    /**
     * 余额充值处理
     * @RequestMapping(route="balanceRecharge", method=RequestMethod::POST)
     */
    public function balanceRechargeByShopMGTd(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidateByPay(), $post);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $data = $this->rechargeLogic->addRechargeData($post);

        if (0 === count($data)) {
            return AjaxReturn::error('充值错误');
        }

        // 余额充值pc
        $post['platform'] = 0;

        $post['special_status'] = 4;

        // 获取支付信息
        $payConfig = $this->logic->getPayInfoByType($post, $req->getCookieParams());

        if (0 === count($payConfig)) {
            return AjaxReturn::error('无法获取支付配置');
        }

        $result = $this->dispatcherPay($payConfig, [
            'order_id' => $data[0],
            'prder_sn' => $data[1]
        ], $post);

        return $result;
    }
}