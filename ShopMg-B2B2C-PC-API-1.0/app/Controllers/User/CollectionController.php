<?php

namespace App\Models\Logic;

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CollectionLogic;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 *
 * @author wq
 * @Controller(perfix="collection")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class CollectionController
{

    /**
     * @Inject()
     *
     * @var CollectionLogic
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
     * 取消收藏 宝贝
     *
     * @RequestMapping(route="cancelCollectionGood", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function cancelCollectionGoodByShopMGWf(Request $req): array
    {
        $ret = $this->logic->cancelUserCollection($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error('删除失败');
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 我收藏的店铺
     *
     * @RequestMapping(route="collectShops", method=RequestMethod::POST)
     */
    public function collectShopsByShopMGPq(Request $req): array
    {
        $ret = $this->logic->my_collection_shops();

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData($ret);
    }

    /**
     * 个人中心首页--商品收藏
     * @RequestMapping(route="mycollectiondity", method=RequestMethod::POST)
     */
    public function mycollectiondityByShopMGHh(Request $req): array
    {
        $result = $this->logic->getMyCollectionGoods();

        if (0 === count($result)) {
            return AjaxReturn::error('暂无收藏');
        }

        $result = $this->goodsLogic->getGoodsByData($result, $this->logic->getSplitKeyByGoods());

        $result = $this->goodsImagesLogic->getImageByArrayGoods($result);

        return AjaxReturn::sendData($result);
    }

    /**
     * 我的收藏--商品搜索
     * @RequestMapping(route="myCollectionGoods", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function myCollectionGoodsByShopMGSu(Request $req): array
    {
        $result = $this->logic->getParseDataByListNoSearch($req->post());
        if (0 === count($result['data'])) {
            return AjaxReturn::error('暂无收藏');
        }

        $result['data'] = $this->goodsLogic->getGoodsByData($result['data'], $this->logic->getSplitKeyByGoods());

        $result['data'] = $this->goodsImagesLogic->getImageByArrayGoods($result['data']);

        return AjaxReturn::sendData($result);
    }

    /**
     * 商品收藏搜索
     * @RequestMapping(route="myCollectionBySearch", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function myCollectionBySearchByShopMGLb(Request $req): array
    {
        $post = $req->post();

        $goodsWhere = $this->goodsLogic->getAssociationCondition($post);

        if ($this->goodsLogic->getWhereExits()) {
            return AjaxReturn::error('暂无数据');
        }

        $result = $this->logic->getCollectionBySearch($post, $goodsWhere);

        if (0 === count($result['data'])) {
            return AjaxReturn::error('暂无收藏');
        }

        $result['data'] = $this->goodsLogic->getGoodsByData($result['data'], $this->logic->getSplitKeyByGoods());

        $result['data'] = $this->goodsImagesLogic->getImageByArrayGoods($result['data']);

        return AjaxReturn::sendData($result['data']);
    }

    /**
     * 我的收藏--删除
     * @RequestMapping(route="myCollectionDel", method=RequestMethod::POST)
     */
    public function myCollectionDelByShopMGDc(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidateByDel(), $post);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }
        $result = $this->logic->getMyCollectionDel($req->post());

        if (!$result) {
            return AjaxReturn::error('删除失败');
        }

        return AjaxReturn::sendData('', '删除成功');
    }
}