<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\UserLevelLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 *
 * @author wq
 * @Controller(prefix="/userLevel")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class UserLevelController
{

    /**
     * @Inject()
     *
     * @var UserLevelLogic
     */
    private $logic;

    /**
     * 用户等级数据
     * @RequestMapping(route="getList", method=RequestMethod::POST)
     */
    public function getListByShopMGMt(Request $req): array
    {
        return AjaxReturn::sendData($this->logic->getListCache());
    }
}
