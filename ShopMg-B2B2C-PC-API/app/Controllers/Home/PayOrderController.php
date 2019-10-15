<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Common\TraitClass\DispatcherPayTrait;
use App\Middlewares\ValidateLoginMiddleware;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 订单支付
 * @Controller(prefix="/payOrder")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author Administrator
 */
class PayOrderController
{
    use DispatcherPayTrait;

    /**
     * 支付类型处理
     *
     * @var array
     */
    private $payName = [
        'Pay\\WxPay',
        'Pay\\Alipay',
        'Pay\\UnionPay',
        'Pay\\BalancePay'
    ];

    /**
     * 通知控制器及其action
     *
     * @var array
     */
    private $notifyURL = [
        '/nofity/wxNofity',
        '/nofity/alipayNotify',
        '/nofity/unionNotify',
        '/nofity/balanceNofty'
    ];

    /**
     *
     * @var string
     */
    private $reuturnURL = [
        '/Nofity/wxNofity',
        '/successCommonAlipay',
        '/unionNotify',
        '/Nofity/balanceNofty'
    ];

    /**
     * @RequestMapping(route="initiatePayment", method=RequestMethod::POST)
     * @Number(name="pay_type_id", min=1)
     */
    public function initiatePaymentByShopMGWc(Request $req): array
    {
        $post = $req->post();

        $post['platform'] = 0;

        $post['special_status'] = 0;

        $data = $this->initiate($post, $req->getCookieParams());

        if (0 === count($data)) {
            return AjaxReturn::error($this->errorMessage);
        }
        return $data;
    }
}