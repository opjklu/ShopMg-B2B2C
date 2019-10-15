<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CouponListLogic;
use App\Models\Logic\Specific\CouponLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Tool\SessionManager;

/**
 * @Controller(prefix="/orderCouponOptions")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class OrderCouponOptionsController
{

    /**
     * @Inject()
     *
     * @var CouponListLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var CouponLogic
     */
    private $couponLogic;

    /**
     * 用户可用代金券
     * @RequestMapping(route="usersCanUseCoupons", method=RequestMethod::POST)
     */
    public function usersCanUseCouponsByShopMGIn(Request $req): array
    {
        $data = $this->logic->getUsersCanUseCoupons();

        if (0 === count($data)) {
            return AjaxReturn::error('暂无优惠券');
        }

        $dataSource = $this->couponLogic->getParseCoupon($data, $this->logic->getSplitKeyByCoupon());

        SessionManager::SET_DO_USE($dataSource['do_use']);

        return AjaxReturn::sendData($dataSource);
    }
}
