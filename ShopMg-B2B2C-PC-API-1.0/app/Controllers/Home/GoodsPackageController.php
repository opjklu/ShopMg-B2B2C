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
 * @Controller(prefix="/goodsPackage")
 *
 * @author Administrator
 */
class GoodsPackageController
{

    /**
     * @Inject()
     *
     * @var GoodsPackageLogic
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
     * @var GoodsLogic
     */
    private $goodsLogic;

    /**
     * @Inject()
     *
     * @var GoodsPackageCartLogic
     */
    private $goodsPackageCartLogic;

    /**
     * @Inject()
     *
     * @var StoreLogic
     */
    private $storeLogic;

    /**
     * @Inject()
     *
     * @var GoodsPackageSubLogic
     */
    private $goodsPackageSubLogic;

    /**
     * 套餐立即购买--获取商品详情
     * @RequestMapping(route="cartPackageBuyNow", method=RequestMethod::POST)
     * @Middleware(ValidateLoginMiddleware::class)
     *
     * @author 米糕网络团队
     */
    public function cartPackageBuyNowByShopMGQw(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByGoodsPackage(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->getPackageBuyNow($post);

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $packageSubData = $this->goodsPackageSubLogic->getPackageSub($ret, $this->logic->getPrimaryKey());

        if (0 === count($packageSubData)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $goodsData = $this->goodsLogic->getParseDataByOrder($packageSubData, $this->goodsPackageSubLogic->getSplitKeyByGoods());

        if (0 === count($goodsData)) {
            return AjaxReturn::error('商品数据错误');
        }

        $goodsImage = $this->goodsImagesLogic->getImageByArrayGoods($goodsData);

        $store = $this->storeLogic->getStoreInfoByStoreIdStringCache($ret, $this->logic->getSplitKeyByStore());

        $sessionOrderManager = new SessionManager($goodsData, $this->logic->getCache());

        $sessionOrderManager->discountPackagePurchaseImmediately((new ArrayChildren($ret))->convertIdByData($this->logic->getPrimaryKey()));

        return AjaxReturn::sendData([
            'goods' => $goodsImage,
            'store' => $store,
            'package' => $ret
        ]);
    }

    /**
     * 得到优惠套餐
     * @RequestMapping(route="package", method=RequestMethod::POST)
     * @Number(name="goods_id", min=1)
     * @Number(name="store_id", min=1)
     */
    public function packageByShopMGQb(Request $req): array
    {
        $post = $req->post();

        $packageList = $this->logic->getPackageListCache($post);

        if (0 === count($packageList)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $subData = $this->goodsPackageSubLogic->parseGoodsIsInPackage($packageList, $post, $this->logic->getPrimaryKey());

        if (0 === count($subData)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $goodsData = $this->goodsLogic->getGoodsByOtherDataCache($subData, $this->goodsPackageSubLogic->getSplitKeyByGoods());

        if (0 === count($goodsData)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $goodsData = $this->goodsImagesLogic->getImageByArrayGoods($goodsData);

        return AjaxReturn::sendData([
            'goods' => $goodsData,
            'package' => $packageList
        ]);
    }

    /**
     * 优惠套餐加入购物车
     * @RequestMapping(route="addPackageCart", method=RequestMethod::POST)
     * @Middleware(ValidateLoginMiddleware::class)
     */
    public function addPackageCartByShopMGVt(Request $req): array
    {
        $post = $req->post();

        // 检测传值 //检测方法
        $checkObj = new CheckParam($this->logic->getValidateByGoodsPackage(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $post['id'] = explode(',', $post['id']);

        $data = $this->logic->getPackageListByIds($post);

        if (0 === count($data)) {
            return AjaxReturn::error('套餐数据错误');
        }

        $status = $this->goodsPackageCartLogic->addPackageToCart($post, $data, $this->logic->getPrimaryKey());

        if (!$status) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }
}