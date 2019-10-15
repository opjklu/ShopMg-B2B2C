<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\ExpressLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;

/**
 * 快递列表
 *
 * @author Administrator
 *
 * @Controller(prefix="/express")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class ExpressController
{

    /**
     * @Inject()
     *
     * @var ExpressLogic
     */
    private $logic;

    /**
     * 获取 快递列表
     * @RequestMapping(route="getExpressList")
     */
    public function getExpressListByShopMGJj(Request $req): array
    {
        return AjaxReturn::sendData($this->logic->getExpressDataListCache());
    }
}
