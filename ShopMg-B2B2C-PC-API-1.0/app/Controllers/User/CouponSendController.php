<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CouponLogic;
use App\Models\Logic\Specific\StoreMemberLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * @Controller(prefix="/couponSend")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class CouponSendController
{

    /**
     * @Inject()
     *
     * @var StoreMemberLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var CouponLogic
     */
    private $couponLogic;

    /**
     * 获取优惠券列表
     * @RequestMapping(route="couponSendList", method=RequestMethod::POST)
     * @Number(name="store_id", min=1)
     * @Number(name="page", min=1)
     */
    public function couponSendListByShopMGAl(Request $req): array
    {
        $post = $req->post();

        $isMemberByCurrentShop = $this->logic->isMemberbByCurrentStore($req->post());

        $data = $this->couponLogic->getCouponListByStoreCache($post, $isMemberByCurrentShop);

        if (0 === count($data['data'])) {
            return AjaxReturn::error('没有可领取的优惠券');
        }

        return AjaxReturn::sendData($data);
    }
}
