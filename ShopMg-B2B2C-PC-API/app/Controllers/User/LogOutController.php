<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/logOut")
 *
 * @author wq
 * @Middleware(ValidateLoginMiddleware::class)
 */
class LogOutController
{

    /**
     * 退出登录
     * @RequestMapping(route="logOut")
     */
    public function logOutByShopMGFj(): array
    {
        session()->flush();

        return AjaxReturn::sendData('');
    }
}