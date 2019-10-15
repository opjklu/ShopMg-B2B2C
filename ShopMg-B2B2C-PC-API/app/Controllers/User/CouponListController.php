<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CouponListLogic;
use App\Models\Logic\Specific\CouponLogic;
use App\Models\Logic\Specific\StoreLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 用户优惠券控制器
 * @author 米糕网络团队
 * @Controller(prefix="/couponList")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class CouponListController
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
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * 我的优惠券：未使用，已使用，已过期
     * @RequestMapping(route="myCouponLists", method=RequestMethod::POST)
     *
     * @name 我的优惠券列表
     * @author 米糕网络团队
     */
    public function myCouponListsByShopMGRw(Request $req): array
    {
        $ret = $this->logic->getParseDataByListNoSearch($req->post()); // 逻辑处理

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('暂无数据');
        } // 获取失败提示并返回

        $ret['data'] = $this->couponLogic->getCouponByData($ret['data'], $this->logic->getSplitKeyByCoupon());

        $ret['data'] = $this->storeLogic->getStoreByData($ret['data'], $this->couponLogic->getSplitKeyByStore());

        return AjaxReturn::sendData($ret); // 返回数据
    }

    /**
     * 使用优惠券
     * @RequestMapping(route="useCoupon", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @author 米糕网络团队
     */
    public function useCouponByShopMGXq(Request $req): array
    {
        $ret = $this->logic->useCoupon();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret); // 返回数据
    }
}
