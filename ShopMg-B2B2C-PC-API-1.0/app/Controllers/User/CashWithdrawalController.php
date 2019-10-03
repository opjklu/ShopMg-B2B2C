<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\DispatcherPayTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\BalanceLogic;
use App\Models\Logic\Specific\CashWithDrawalLogic;
use App\Models\Logic\Specific\PayLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 提现
 * @Controller(perfix="cashWithdrawal")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author Administrator
 */
class CashWithdrawalController
{
    use DispatcherPayTrait;

    /**
     * @Inject()
     *
     * @var CashWithDrawalLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var PayLogic
     */
    private $payLogic;

    /**
     * @Inject()
     *
     * @var BalanceLogic
     */
    private $balanceLogic;

    /**
     * 退款类型处理
     *
     * @var array
     */
    private $refundName = [
        'Pay\\BalanceRechargeByWxPay',
        'Pay\\BalanceRechargeByAlipay',
        '',
        ''
    ];

    /**
     * 提现行为
     * @RequestMapping(route="cashBehavior", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function cashBehaviorByShopMGOc(Request $req): array
    {
        $post = $req->post();

        $cashInfo = $this->logic->getCashInfo($post);

        if (0 === count($cashInfo)) {
            return AjaxReturn::sendData($this->logic->getErrorMessage());
        }

        // 余额充值pc
        $cashInfo['platform'] = 0;

        $cashInfo['special_status'] = 4;

        // 获取支付信息
        $payConfig = $this->payLogic->getPayConfig($cashInfo, $req->getCookieParams());

        if (0 === count($payConfig)) {
            return AjaxReturn::error('无法获取支付配置');
        }

        if (false === $this->balanceLogic->cashDelMoney($cashInfo)) {
            return AjaxReturn::error($this->balanceLogic->getErrorMessage());
        }

        $result = $this->dispatcherCashWithdrawal($payConfig, $cashInfo, $post);

        if (0 === count($result)) {
            $this->balanceLogic->rollBack();

            return AjaxReturn::error($this->errorMessage);
        }

        if (false === $this->logic->cashBehaviorEditStatus($post, $result)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        return AjaxReturn::sendData('');
    }
}
