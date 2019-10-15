<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CouponListLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/couponReceive")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class CouponReceiveController
{

    /**
     * @Inject()
     *
     * @var CouponListLogic
     */
    private $logic;

    /**
     * 领取优惠券
     * @RequestMapping(route="couponReceiveBehavior", method={RequestMethod::POST})
     * @Number(name="type", min=0, max=1)
     * @Number(name="c_id", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function couponReceiveBehaviorByShopMGDc(Request $req): array
    {
        $status = $this->logic->addData($req->post());

        if (!$status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}
