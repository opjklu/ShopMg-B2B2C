<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\PayTypeLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/getPayType")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class GetPayTypeController
{

    /**
     * @Inject()
     *
     * @var PayTypeLogic
     */
    private $logic;

    /**
     * 获取支付类型
     * @RequestMapping(route="getPayResult", method=RequestMethod::POST)
     */
    public function getPayResultByShopMGTf(): array
    {
        return AjaxReturn::sendData($this->logic->getResult());
    }

    /**
     * 获取支付类型
     * @RequestMapping(route="getPayRechargeResult", method=RequestMethod::POST)
     */
    public function getPayRechargeResultByShopMGHk(): array
    {
        return AjaxReturn::sendData($this->logic->getPayType());
    }
}
