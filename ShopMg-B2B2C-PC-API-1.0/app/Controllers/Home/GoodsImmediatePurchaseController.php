<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\StoreLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Tool\SessionManager;

/**
 * 商品立即购买
 * @Controller(perfix="/goodsImmediatePurchase")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class GoodsImmediatePurchaseController
{

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * 立即购买生成 session相关数据
     * @RequestMapping(route="buyNowByBuildSession", method = RequestMethod::POST)
     * @Number(name="id", min=1)
     * @Number(name="goods_num", min=1)
     *
     * @author 米糕网络团队
     */
    public function buyNowByBuildSessionByShopMGDd(Request $req): array
    {
        $post = $req->post();

        $ret = $this->logic->getGoodsDetailByOrder($post);

        if (count($ret) === 0) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }
        // 获取商品图片

        $image = $this->goodsImagesLogic->getThumbImagesByGoodsId($ret, $this->logic->getSplitKeyByPId());

        // 获取店铺信息
        $store = $this->storeLogic->getInfo($ret, $this->logic->getSplitKeyByStore());

        if (count($store) === 0) {
            return AjaxReturn::error($this->storeLogic->getErrorMessage());
        }

        $ret['goods_num'] = $post['goods_num'];

        $sessionOrder = new SessionManager($ret, $this->logic->getCacheDriver());

        $sessionOrder->sessionBuyNow();

        return AjaxReturn::sendData([
            'goods' => $ret,
            'store' => $store,
            'image' => $image
        ]);
    }
}