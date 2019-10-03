<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\IntegralGoodsLogic;
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
use Validate\CheckParam;

/**
 * 积分商品列表
 * @Controller(perfix="integralGoods")
 *
 * @author wq
 */
class IntegralGoodsController
{

    /**
     * @Inject()
     *
     * @var IntegralGoodsLogic
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
     * 获取积分商城热兑商品
     * @RequestMapping(route="heateXchange", method=RequestMethod::POST)
     */
    public function heateXchangeByShopMGEh(Request $req): array
    {
        $ret = $this->logic->getHeateXchange();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret['data'], $ret['status'], $ret['message']);
    }

    /**
     * 获取最新积分商品列表
     * @RequestMapping(route="integralGoodsNewList", method=RequestMethod::POST)
     */
    public function integralGoodsNewListByShopMGJd(Request $req): array
    {
        $ret = $this->logic->getNewList();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $ret = $this->goodsLogic->getGoodsDataByIntegral($ret, $this->logic->getSplitKeyByGoods());

        $ret = $this->goodsImagesLogic->getImageByArrayGoods($ret);

        return AjaxReturn::sendData($ret);
    }

    /**
     * 获取积分商品列表
     *
     * @RequestMapping(route="integralGoodsList", method=RequestMethod::POST)
     */
    public function integralGoodsListByShopMGVn(Request $req): array
    {
        $ret = $this->logic->getAllIntegralGoods();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret['data'], $ret['status'], $ret['message']);
    }

    /**
     * 去结算获取商品信息
     * @Middleware(ValidateLoginMiddleware::class)
     * @RequestMapping(route="toSettleAccounts", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     * @Number(name="goods_num", min=1)
     */
    public function toSettleAccountsByShopMGCf(Request $req): array
    {
        $post = $req->post();

        $ret = $this->logic->checkIsConvertibility($post);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $integral = &$ret;

        $integral['goods_num'] = $post['goods_num'];

        // 商品信息
        $goodsData = $this->goodsLogic->getGoodsInfoByGoodsId($integral, $this->logic->getSplitKeyByGoods());

        if (0 === count($goodsData)) {
            return AjaxReturn::error('商品异常');
        }

        $data = $this->goodsImagesLogic->getThumbImagesByGoodsId($goodsData, $this->goodsLogic->getSplitKeyByPId());

        $storeInfo = $this->storeLogic->getInfo($goodsData, $this->goodsLogic->getSplitKeyByStore());

        $goodsData['goods_num'] = $post['goods_num'];

        $goodsData['price_member'] = $integral['money'];

        $goodsData['integral'] = $integral['integral'];

        $sessionManager = new SessionManager($goodsData, $this->logic->getCache());

        $sessionManager->sessionBuyNowByIntegralGoods();

        return AjaxReturn::sendData(array_merge($storeInfo, $data, $goodsData, $integral));
    }
}