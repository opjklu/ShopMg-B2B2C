<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsCartLogic;
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
use Tool\ArrayChildren;
use Tool\SessionManager;
use Validate\CheckParam;

/**
 * 购物车
 * @Controller(perfix="goodsCart")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class GoodsCartController
{

    /**
     * @Inject()
     *
     * @var GoodsCartLogic
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
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * 加入购物车
     * @RequestMapping(route="addGoodToCart", method=RequestMethod::POST)
     * @Number(name="goods_id", min=1)
     * @Number(name="goods_num", min=1)
     */
    public function addGoodToCartByShopMGDa(Request $req): array
    {
        $post = $req->post();

        $goodsDetail = $this->goodsLogic->getGoodsDetailCacheKey($post, $this->logic->getSplitKeyByGoodsId());

        if (0 === count($goodsDetail)) {
            return AjaxReturn::error('商品数据错误');
        }

        $goodsDetail['goods_num'] = $post['goods_num'];

        $result = $this->logic->addCart($goodsDetail);

        if (!$result) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 显示购物车商品数量
     * @RequestMapping(route="getCount")
     */
    public function getCountByShopMGUx(): array
    {
        $ret = $this->logic->getGoodsCount();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 购物车列表
     * @RequestMapping(route="cartGoodsList", method=RequestMethod::POST)
     */
    public function cartGoodsListByShopMGDl(): array
    {
        $ret = $this->logic->getCartGoodsList();

        if (0 === count($ret)) {
            return AjaxReturn::error('购物车没有数据');
        }
        // 商品
        $ret = $this->goodsLogic->getGoodsByData($ret, $this->logic->getSplitKeyByGoodsId());

        // 商户
        $store = $this->storeLogic->getStoreInfoByStoreIdStringCache($ret, $this->logic->getSplitKeyByStoreId());

        // 图片
        $ret = $this->goodsImagesLogic->getImageByArrayGoods($ret);

        return AjaxReturn::sendData([
            'cart' => $ret,
            'store' => $store
        ]);
    }

    /**
     * 购物车商品数修改(
     * @RequestMapping(route="cartNumModify", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     * @Number(name="num", min=1)
     * @Number(name="goods_id", min=1)
     */
    public function cartNumModifyByShopMGQp(Request $req): array
    {
        $post = $req->post();

        $status = $this->goodsLogic->isThereEnoughStock($post);

        if ($status === false) {
            return AjaxReturn::error($this->goodsLogic->getErrorMessage());
        }

        $ret = $this->logic->getCartNumModify($post);

        if (!$ret) {
            return AjaxReturn::error('修改失败');
        }
        return AjaxReturn::sendData($ret);
    }

    /**
     * 编辑购物车
     * @RequestMapping(route="delGoodsCart", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function delGoodsCartByShopMGJn(Request $req): array
    {
        $ret = $this->logic->delGoodsCart($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('删除失败');
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * *
     * 获取购物车购买商品的信息
     * @RequestMapping(route="userBuyCartGoods", method=RequestMethod::POST)
     */
    public function userBuyCartGoodsByShopMGEi(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getUserBuyCarGoodsInfo(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->getGoodsCartInfoCache($post);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        // 获取商品信息

        $ret = $this->goodsLogic->getGoodsByOtherDataCache($ret, $this->logic->getSplitKeyByGoodsId());

        if (0 === count($ret)) {
            return AjaxReturn::error($this->goodsLogic->getErrorMessage());
        }

        // 获取图片
        $ret = $this->goodsImagesLogic->getImageByArrayGoods($ret);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->goodsImagesLogic->getErrorMessage());
        }

        // 获取店铺信息

        $splitKeyByStore = $this->logic->getSplitKeyByStoreId();

        $store = $this->storeLogic->getStoreInfo($ret, $splitKeyByStore);

        if (0 === count($store)) {
            return AjaxReturn::error($this->storeLogic->getErrorMessage());
        }

        $cartSession = new SessionManager($ret, $this->logic->getCacheManager());

        $cartSession->sessionParse();

        // 按店铺拆分
        $storeData = (new ArrayChildren($ret))->inTheSameState($splitKeyByStore);

        $returnData = [
            'shop_goods_info' => $storeData,
            'total_price' => $cartSession->getTotalPrice(),
            'store' => $store,
            'total_number' => $cartSession->getTotalNumber()
        ];

        return AjaxReturn::sendData($returnData);
    }

    /**
     * 删除购物车商品
     * @RequestMapping(route="deleteManyGoodsCart", method=RequestMethod::POST)
     */
    public function deleteManyGoodsCartByShopMGNm(Request $req): array
    {
        $post = $req->post();
        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getCartIdValidate(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $result = $this->logic->delManyGoodsCarts($post);

        if (!$result) {
            return AjaxReturn::error('删除失败');
        }

        return AjaxReturn::sendData('');
    }
}