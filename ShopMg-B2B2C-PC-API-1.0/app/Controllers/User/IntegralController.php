<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\IntegralUseLogic;
use App\Models\Logic\Specific\OrderLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 积分控制器
 * @Controller(prefix="/integral")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class IntegralController
{

    /**
     * @Inject()
     *
     * @var IntegralUseLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var OrderLogic
     */
    private $orderLogic;

    /**
     * 我的积分列表
     * @RequestMapping(route="getOwnIntegralList", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function getOwnIntegralListByShopMGLg(Request $req): array
    {
        $data = $this->logic->getParseDataByList($req->post());

        if (0 === count($data['data'])) {
            return AjaxReturn::error('暂无数据');
        }

        $data['data'] = $this->orderLogic->getOrderSnByData($data['data'], $this->logic->getSplitKeyByOrderId());

        return AjaxReturn::sendData($data);
    }
}

