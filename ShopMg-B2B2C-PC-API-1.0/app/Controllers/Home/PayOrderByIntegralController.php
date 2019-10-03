<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Common\TraitClass\DispatcherPayTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\IntegralUseLogic;
use App\Models\Logic\Specific\UserDataLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 积分支付
 * @Controller(perfix="/payOrderByIntegral")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class PayOrderByIntegralController
{
    use DispatcherPayTrait;

    /**
     * @Inject()
     *
     * @var UserDataLogic
     */
    private $useDataLogic;

    /**
     * @Inject()
     *
     * @var IntegralUseLogic
     */
    private $integralUseLogic;

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
        '/notifyByIntegral/wxNofity',
        '/notifyByIntegral/alipayNotify',
        '/nofity/unionNotify',
        '/notifyByIntegral/balanceNofty'
    ];

    /**
     *
     * @var string
     */
    private $reuturnURL = [
        '/NotifyByIntegral/wxNofity',
        '/successAlipay',
        '/unionNotify',
        '/NotifyByIntegral/balanceNofty'
    ];

    /**
     * @RequestMapping(route="initiatePayment", method=RequestMethod::POST)
     * @Number(name="pay_type_id", min=1)
     */
    public function initiatePaymentByShopMGOp(Request $req): array
    {
        $post = $req->post();

        $post['platform'] = 0;

        $post['special_status'] = 2;

        $data = $this->initiate($post, $req->getCookieParams());

        if (0 === count($data)) {
            return AjaxReturn::error($this->errorMessage);
        }

        if (false === $this->integralCallBack()) {
            return AjaxReturn::error('积分处理错误');
        }

        return $data;
    }

    /**
     * 积分支付处理
     *
     * @return array
     */
    protected function integralCallBack(): bool
    {
        $orderData = session()->get('order_data');

        $integralNumber = $this->useDataLogic->integralSettleMement($orderData);

        if (0 === ($integralNumber)) {
            $this->setErrorMessage($this->useDataLogic->getErrorMessage());
            return false;
        }

        $status = $this->integralUseLogic->addIntegralLog($orderData, $integralNumber);

        if ($status === false) {
            $this->setErrorMessage($this->integralUseLogic->getErrorMessage());
            return false;
        }

        return true;
    }
}