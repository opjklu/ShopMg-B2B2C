<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Common\TraitClass\CallIsPayReturnClientTrait;
use App\Common\TraitClass\GetGoodsInforByOrderTrait;
use App\Common\TraitClass\ImmediatePaymentTrait;
use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OrderIntegralGoodsLogic;
use App\Models\Logic\Specific\OrderIntegralLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 积分订单
 * @Controller(prefix="/integralOrders")
 * @Middleware(ValidateLoginMiddleware::class)
 *
 * @author wq
 */
class IntegralOrdersController
{

    use CallIsPayReturnClientTrait;

    use GetGoodsInforByOrderTrait;

    use ImmediatePaymentTrait;

    /**
     * @Inject()
     *
     * @var OrderIntegralGoodsLogic
     */
    private $orderRelatedLogic;

    /**
     * @Inject()
     *
     * @var OrderIntegralLogic
     */
    private $logic;

    /**
     * 积分订单列表
     * @RequestMapping(route="integralList", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function integralListByShopMGAs(Request $req): array
    {
        $data = $this->logic->getParseDataByListNoSearch($req->post());

        if (0 === count($data['data'])) {
            return AjaxReturn::error('暂无数据');
        }

        return AjaxReturn::sendData($this->getOrderSubsidiaryInformation($data));
    }

    /**
     * 个人中心--搜索订单
     * @RequestMapping(route="orderSearch", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function orderSearchByShopMGJf(Request $req): array
    {
        $ret = $this->logic->getOrder($req->post());

        if (0 === count($ret['data'])) {
            return AjaxReturn::error('没有搜索到数据');
        }

        $data = $this->getOrderSubsidiaryInformation($ret);

        return AjaxReturn::sendData($data);
    }

    /**
     * 订单附属信息
     *
     * @param array $data
     * @return array
     */
    private function getOrderSubsidiaryInformation(array $data): array
    {
        // 订单商品数据
        $orderGoods = $this->orderRelatedLogic->getOrderGoodsByInfo($data['data'], $this->logic->getPrimaryKey());

        if (0 === count($orderGoods)) {
            return AjaxReturn::error('积分订单商品异常');
        }

        // 店铺数据
        $data['data'] = $this->storeLogic->getStoreByData($data['data'], $this->logic->getSplitKeyByStore());

        // 商品数据
        $orderGoods = $this->goodsLogic->getGoodsByData($orderGoods, $this->orderRelatedLogic->getSplitKeyByGoods());

        // 商品图片数据
        $orderGoods = $this->goodsImagesLogic->getImageByArrayGoods($orderGoods);

        return [
            'order' => $data,
            'order_goods' => $orderGoods
        ];
    }

    /**
     * 取消订单
     * @RequestMapping(route="cancelOrder", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function cancelOrderByShopMGQg(Request $req): array
    {

        $ret = $this->logic->cancelOrder($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 删除积分订单
     * @RequestMapping(route="delOrder", method=RequestMethod::POST)
     * @Number(name="id", min=1)
     */
    public function delOrderByShopMGDn(Request $req): array
    {
        $ret = $this->logic->delOrder($req->post());

        if (0 === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 组装 商品信息 用于 减库存。。。
     */
    private function buildPayParam(array $post): bool
    {
        return $this->orderRelatedLogic->statisticalPurchaseQuantity($post, 'id');
    }
}