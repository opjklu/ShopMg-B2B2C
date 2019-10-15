<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\UserHeaderLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 保存头像
 *
 * @author Administrator
 *
 * @Controller(prefix="/userHeader")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class UserHeaderController
{



    /**
     * @Inject()
     *
     * @var UserHeaderLogic
     */
    private $logic;

    /**
     * @RequestMapping(route="parseuserHeader", method=RequestMethod::POST)
     *
     * @param Request $req
     * @return array
     */
    public function parseuserHeaderByShopMGSs(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidateUserHeader(), $post);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $status = $this->logic->parseUserHeader($post);

        if (!$status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}
