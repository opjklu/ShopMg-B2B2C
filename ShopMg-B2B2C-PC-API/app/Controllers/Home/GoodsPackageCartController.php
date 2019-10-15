<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\GoodsPackageCartLogic;
use App\Models\Logic\Specific\GoodsPackageLogic;
use App\Models\Logic\Specific\GoodsPackageSubLogic;
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
 * @Controller(prefix="/goodsPackageCart")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class GoodsPackageCartController
{

    /**
     * @Inject()
     *
     * @var GoodsPackageCartLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var GoodsPackageLogic
     */
    private $goodsPackageLogic;

    /**
     * @Inject()
     *
     * @var GoodsPackageSubLogic
     */
    private $goodsPackageSubLogic;

    /**
     * @Inject()
     *
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * @Inject()
     *
     * @var GoodsImagesLogic
     */
    private $goodsImagesLogic;

    /**
     * 购物车套餐列表
     *
     * @author 米糕网络团队
     * @RequestMapping(route="cartPackageList", method=RequestMethod::POST)
     */
    public function cartPackageListByShopMGSm(Request $req): array
    {
        $ret = $this->logic->getCartGoodsList($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('暂无数据');
        }

        $packageKey = $this->logic->getSplitKeyByPackage();

        $ret = $this->goodsPackageLogic->getPackageByPackageCart($ret, $packageKey);;

        $packageSub = $this->goodsPackageSubLogic->getGoodsPackageSubListByPackageCache($ret, $packageKey);

        $goods = $this->goodsLogic->getGoodsByData($packageSub, $this->goodsPackageSubLogic->getSplitKeyByGoods());

        $goods = $this->goodsImagesLogic->getImageByArrayGoods($goods);

        $store = $this->storeLogic->getStoreInfoByStoreIdStringCache($ret, $this->logic->getSplitKeyByStore());

        return AjaxReturn::sendData([
            'cart' => $ret,
            'goods' => $goods,
            'store' => $store
        ]);
    }

    /**
     * 购物车套餐列表--删除
     *
     * @author 米糕网络团队
     * @RequestMapping(route="cartPackageDel", method=RequestMethod::POST)
     */
    public function cartPackageDelByShopMGHx(Request $req): array
    {
        $post = $req->post();
        
        $checkObj = new CheckParam($this->logic->getValidateById(), $post);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->getCartGoodsDel();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }



    /**
     * 购物车套餐数量减
     *
     * @author 米糕网络团队
     * @RequestMapping(route="cartNumReduce", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     * @Number(name="package_num", min=1, max=100)
     */
    public function cartNumReduceByShopMGKo(Request $req): array
    {
        $ret = $this->logic->getCartNumReduce($req->post());

        if (!$ret) {
            return AjaxReturn::error('减少数量失败');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 购物车套餐数修改
     *
     * @author 米糕网络团队
     * @RequestMapping(route="cartNumModify", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     * @Number(name="package_num", min=1, max=100)
     */
    public function cartNumModifyByShopMGUn(Request $req): array
    {
        $ret = $this->logic->getCartNumModify($req->post());

        if (!$ret) {
            return AjaxReturn::error('添加数量失败');
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 套餐购物车--去结算
     *
     * @author 米糕网络团队
     * @RequestMapping(route="toSettleAccounts", method=RequestMethod::POST)
     */
    public function toSettleAccountsByShopMGNu(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidateByLogin(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $packageCart = $this->logic->getPackageInfoByCart($post);

        if (0 === count($packageCart)) {
            return AjaxReturn::error('套餐信息错误');
        }

        $packageCart = $this->goodsPackageLogic->getPackageByPackageCart($packageCart, $this->logic->getSplitKeyByPackage());

        if (0 === count($packageCart)) {
            return AjaxReturn::error('套餐信息错误');
        }

        $packageCart = (new ArrayChildren($packageCart))->convertIdByData($this->logic->getSplitKeyByPackage());

        // 套餐商品
        $goodsSubGoods = $this->goodsPackageSubLogic->getGoodsPackageSubDataByGoodsCart($packageCart, $this->logic->getSplitKeyByPackage());

        if (0 === count($goodsSubGoods)) {
            return AjaxReturn::error('套餐商品信息错误');
        }

        $goodsData = $this->goodsLogic->getParseDataCartByOrder($goodsSubGoods, $this->goodsPackageSubLogic->getSplitKeyByGoods());

        if (0 === count($goodsData)) {
            return AjaxReturn::error('套餐商品信息错误');
        }

        $goodsData = $this->goodsImagesLogic->getImageByArrayGoods($goodsData);

        $store = $this->storeLogic->getStoreInfoByStoreIdStringCache($packageCart, $this->logic->getSplitKeyByStore());

        $sessionManager = new SessionManager($goodsData, $this->goodsLogic->getCacheDriver());

        $sessionManager->discountPackagePurchaseImmediately($packageCart);

        return AjaxReturn::sendData([
            'goods' => $goodsData,
            'store' => $store
        ]);
    }

    /**
     * 套餐购物车--删除订单
     * @RequestMapping(route="delOrder", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function delOrderByShopMGMc(Request $req): array
    {
        $ret = $this->logic->toDelOrder($req->post());

        if ($ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }
}