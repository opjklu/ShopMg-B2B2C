<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\GoodsImagesLogic;
use App\Models\Logic\Specific\GoodsLogic;
use App\Models\Logic\Specific\OrderPackageGoodsLogic;
use App\Models\Logic\Specific\OrderPackageLogic;
use App\Models\Logic\Specific\OrderPackageReturnGoodsLogic;
use App\Models\Logic\Specific\OrderPackageReviewProgressLogic;
use App\Models\Logic\Specific\StoreLogic;
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
 * 套餐订单退货
 * @Controller(perfix="orderPackageReturnGoods")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class OrderPackageReturnGoodsController
{

    /**
     * @Inject()
     *
     * @var OrderPackageReturnGoodsLogic
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
     * @var OrderPackageLogic
     */
    private $orderLogic;
    
    /**
     * @Inject()
     *
     * @var OrderPackageReviewProgressLogic
     */
    private $orderPackageReviewProgressLogic;
    
    /**
     * @Inject()
     * @var OrderPackageGoodsLogic
     */
    private $orderPackageGoodsLogic;

    /**
     * 提退货申请
     * @RequestMapping(route="customerService", method=RequestMethod::POST)
     *
     * @param Request $req
     * @return array
     */
    public function customerServiceByShopMGBb(Request $req): array
    {
        $post = $req->post();
        
        $checkObj = new CheckParam($this->logic->getValidateByApply(), $post);
        
        if (false === $checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }
        
        $ret = $this->logic->applyForAfterSale($post);

        if (0 === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

       
        $status = $this->orderPackageReviewProgressLogic->addProcess([ 'insert_id' => $ret]);

        if (!$status) {
            return AjaxReturn::error($this->orderPackageReviewProgressLogic->getErrorMessage());
        }

        $status = $this->orderPackageGoodsLogic->updateReturnGoodsStatus($post);

        if (!$status) {
            return AjaxReturn::error($this->orderPackageGoodsLogic->getErrorMessage());
        }
        return AjaxReturn::sendData('');
    }

    /**
     * 填写快递单号
     * @RequestMapping(route="courierNumber", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     * @Number(name="express_id", min=1)
     * @Number(name="waybill_id", min=1)
     * @param Request $req
     * @return array
     */
    public function courierNumberByShopMGAe(Request $req): array
    {

        $post = $req->post();
        
        $ret = $this->logic->setCourierNumber($post);

        if (false === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $orderStatus = $this->orderPackageGoodsLogic->updateRetuernGoodsReceiveStatus($post);

        if (false === $ret) {
            return AjaxReturn::error($this->orderPackageGoodsLogic->getErrorMessage());
        }
        return AjaxReturn::sendData('');
    }

    /**
     * 申请售后列表
     * @RequestMapping(route="progressQueryList", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function progressQueryListByShopMGCt(Request $req): array
    {
        $result = $this->logic->getParseDataByListNoSearch($req->post());

        if (0 === count($result['data'])) {
            return AjaxReturn::error('暂无套餐退货');
        }

        $result = $this->getSubsidiaryByOrder($result);

        return AjaxReturn::sendData($result);
    }

    /**
     *
     * @return array
     */
    private function getSubsidiaryByOrder(array $result): array
    {
        $result['data'] = $this->orderLogic->getOrderSnByData($result['data'], $this->logic->getSplitKeyByOrderId());

        $result['data'] = $this->goodsLogic->getGoodsByData($result['data'], $this->logic->getSplitKeyByGoodsId());

        $result['data'] = $this->goodsImagesLogic->getImageByArrayGoods($result['data']);

        return $result;
    }

    /**
     * 申请售后详情
     * @RequestMapping(route="progressQuery", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     *
     * @param Request $req
     * @return array
     */
    public function progressQueryByShopMGXd(Request $req): array
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

    /**
     * 查询订单
     * @RequestMapping(route="searchOrder", method=RequestMethod::POST)
     *
     * @param Request $req
     * @return array
     */
    public function searchOrderByShopMGJl(Request $req): array
    {
        $post = $req->post();

        $accsessWhere = $this->orderLogic->getAssociationCondition($post);
        if ($this->orderLogic->getWhereExits()) {
            return AjaxReturn::error('暂无数据');
        }

        $ret = $this->logic->getSearchOrder($post, $accsessWhere);

        if (0 === count($ret['data'])) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $ret = $this->getSubsidiaryByOrder($ret);

        return AjaxReturn::sendData($ret);
    }
}