<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\BalanceLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;

/**
 * @Controller(prefix="balance")
 * @Middleware(ValidateLoginMiddleware::class)
 * 余额控制器
 */
class BalanceController
{

    /**
     * @Inject()
     *
     * @var BalanceLogic
     */
    private $logic;

    /**
     * 獲取餘額
     * @RequestMapping(route="getBalance", method={RequestMethod::POST})
     */
    public function getBalanceByShopMGGg(): array
    {
        $ret = $this->logic->getBalance();

        return AjaxReturn::sendData($ret['data'], $ret['message']);
    }
}