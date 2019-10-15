<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 wq.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://wq.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CommonOrderApplyForAfterSaleLogic;
use App\Models\Logic\Specific\OrderGoodsLogic;
use App\Models\Logic\Specific\OrderReviewProgressLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 普通订单申请售后
 *
 * @author Administrator
 *
 * @Controller(prefix="/commonOrderApplyForAfterSale")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class CommonOrderApplyForAfterSaleController
{

    /**
     * @Inject()
     *
     * @var CommonOrderApplyForAfterSaleLogic
     */
    private $logic;
    
    /**
     * @Inject()
     * @var OrderReviewProgressLogic
     */
    private $orderReviewProgressLogic;
    
    /**
     * @Inject()
     * @var OrderGoodsLogic
     */
    private $orderGoodsLogic;
    

    /**
     * 提交售后申请
     * @RequestMapping(route="customerService", method=RequestMethod::POST)

     * @param Request $req
     * @return array
     */
    public function customerServiceByShopMGNa(Request $req): array
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
        $status = $this->orderReviewProgressLogic->addOrderReview([ 'order_return' => $lastId]);

        if (false === $status) {
            return AjaxReturn::error($this->orderReviewProgressLogic->getErrorMessage());
        }
        
        $status = $this->orderGoodsLogic->returnAuditStatusByTrancestation($post);

        if (false === $status) {
            return AjaxReturn::error($this->orderGoodsLogic->getErrorMessage());
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
    public function courierNumberByShopMGNg(Request $req): array
    {
       
        $post = $req->post();
        
        $ret = $this->logic->setCourierNumber($post);

        if (false === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $status = $this->orderGoodsLogic->updateRetuernGoodsReceiveStatus($post);

        if (false === $ret) {
            return AjaxReturn::error($this->orderGoodsLogic->getErrorMessage());
        }
        
        return AjaxReturn::sendData('');
    }

    /**
     * 申请售后列表
     * @RequestMapping(route="progressQueryList", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function progressQueryListByShopMGFb(Request $req): array
    {
        return [];
    }

    // 查询订单
    public function searchOrderByShopMGOd(Request $req): array
    {
        return [];
    }
}