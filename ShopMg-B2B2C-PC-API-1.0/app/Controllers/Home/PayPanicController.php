<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Common\TraitClass\DispatcherPayTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OrderWxpayLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Tool\SessionManager;

/**
 * @Controller(perfix="payPanic")
 * 订单支付
 *
 * @author Administrator
 * @Middleware(ValidateLoginMiddleware::class)
 */
class PayPanicController
{
    use DispatcherPayTrait;

    /**
     * @Inject()
     *
     * @var OrderWxpayLogic
     */
    private $orderWxlogic;

    /**
     * @RequestMapping(route="initiatePayment", method=RequestMethod::POST)
     * @Number(name="pay_type_id", min=1)
     */
    public function initiatePaymentByShopMGMq(Request $req): array
    {
        $post = $req->post();

        $post['platform'] = 0;

        $post['special_status'] = 0;

        $payConfig = $this->logic->getPayInfoByType($post, $req->getCookieParams());

        if (0 === count($payConfig)) {
            return AjaxReturn::error('无法获取支付配置');
        }

        $orderData = SessionManager::GET_ORDER_DATA();

        $result = $this->dispatcherPay($payConfig, $orderData, $post, $this->orderWxlogic);

        return $result;
    }
}