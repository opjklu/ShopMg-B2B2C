<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\OrderLogic;
use App\Models\Logic\Specific\OrderReturnGoodsLogic;
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
 * 订单退货
 * @Controller(perfix="orderReturnGoods")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class OrderReturnGoodsController
{

    /**
     * @Inject()
     *
     * @var OrderReturnGoodsLogic
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
    private $goodsImagesLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * @Inject()
     *
     * @var OrderLogic
     */
    private $orderLogic;

    /**
     * 退货--退货列表
     * @RequestMapping(route="orderReturnList", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @author 米糕网络团队
     */
    public function orderReturnListByShopMGPd(Request $req): array
    {
        $result = $this->logic->getParseDataByListNoSearch($req->post());

        if (0 === count($result['data'])) {
            return AjaxReturn::error('暂无退货信息列表');
        }

        $result['data'] = $this->orderLogic->getOrderSnByData($result['data'], $this->logic->getSplitKeyByOrderId());

        $result['data'] = $this->goodsLogic->getGoodsByData($result['data'], $this->logic->getSplitKeyByGoodsId());

        $result['data'] = $this->goodsImagesLogic->getImageByArrayGoods($result['data']);

        return AjaxReturn::sendData($result);
    }

    /**
     * @RequestMapping(route="orderReturnDetails", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @name 退货--退货详情
     * @author 米糕网络团队
     */
    public function orderReturnDetailsByShopMGRa(Request $req): array
    {
        $result = $this->logic->getOrderReturnDetails($req->post());
        if (0 === count($result)) {
            return AjaxReturn::error('暂无退货信息');
        }

        $goods = $this->goodsLogic->getGoodInfoByOneOfTheTotalCommoditiesCache($result, $this->logic->getSplitKeyByGoodsId());

        $images = $this->goodsImagesLogic->getThumbImagesByGoodsId($goods, $this->goodsLogic->getSplitKeyByPid());

        $store = $this->storeLogic->getInfo($result, $this->logic->getSplitKeyByStoresId());

        $order = $this->orderLogic->getOrderDetailByOrderReturnRetuernGoods($result, $this->logic->getSplitKeyByOrderId());

        return AjaxReturn::sendData(array_merge($store, $goods, $images, $order, $result));
    }
}

        


