<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\CallIsPayReturnClientTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\RechargeLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Server\Bean\Annotation\Controller;

/**
 * 余额支付是否成功
 *
 * @author Administrator
 *
 * @Controller(prefix="/balanceRecharge")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class BalanceRechargeController
{

    use CallIsPayReturnClientTrait;

    /**
     * @Inject()
     *
     * @var RechargeLogic
     */
    private $logic;
}
