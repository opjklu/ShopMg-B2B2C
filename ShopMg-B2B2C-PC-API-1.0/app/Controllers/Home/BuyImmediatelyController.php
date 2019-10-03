<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\PanicBuyLogic;
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
 * @Controller(perfix="buyImmediately")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class BuyImmediatelyController
{

    /**
     * @Inject()
     *
     * @var PanicBuyLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImageLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * 购买
     * @RequestMapping(route="buy", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     * @Number(name="goods_num", min=1)
     */
    public function buyByShopMGNb(Request $req): array
    {
        $post = $req->post();

        $panicData = $this->logic->beforeImmediatelyBuy($post);

        if (0 === count($panicData)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $goodsData = $this->goodsLogic->getPanicGoodsDetailCacheKey($panicData, $this->logic->getGoodsBySplitKey());

        if (0 === count($goodsData)) {
            return AjaxReturn::error($this->goodsLogic->getErrorMessage());
        }

        // 获取商品图片
        $image = $this->goodsImageLogic->getThumbImagesByGoodsId($goodsData, $this->goodsLogic->getSplitKeyByPid());

        // 获取店铺信息
        $store = $this->storeLogic->getInfo($goodsData, $this->goodsLogic->getSplitKeyByStore());

        if (0 === count($store)) {
            return AjaxReturn::error($this->storeLogic->getErrorMessage());
        }

        $goodsData['goods_num'] = $post['goods_num'];

        $sessionOrder = new SessionManager($goodsData, $this->logic->getCache());

        $sessionOrder->sessionBuyNow();

        return AjaxReturn::sendData([
            'goods' => $goodsData,
            'store' => $store,
            'image' => $image
        ]);
    }
}
