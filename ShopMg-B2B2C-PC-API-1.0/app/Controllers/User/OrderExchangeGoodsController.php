<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OrderExchangeGoodsLogic;
use App\Models\Logic\Specific\OrderExchangeProgressLogic;
use App\Models\Logic\Specific\OrderGoodsLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Bean\Annotation\Number;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 普通订单换货
 *
 * @author Administrator
 *
 * @Controller(perfix="orderExchangeGoods")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class OrderExchangeGoodsController
{
    /**
     * @Inject()
     *
     * @var OrderExchangeGoodsLogic
     */
    private $logic;
    
    /**
     * @Inject()
     *
     * @var OrderExchangeProgressLogic
     */
    private $rderExchangeProgressLogic;
    
    /**
     * @Inject()
     *
     * @var OrderGoodsLogic
     */
    private $orderGoodsLogic;

    /**
     * 提交售后申请
     * @RequestMapping(route="customerService", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function customerServiceByShopMGEs(Request $req): array
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
        
        $status = $this->orderExchangeProgressLogic->addProcess(['insert_id' => $ret]);
        
        if (!$status) {
            return AjaxReturn::error($this->orderExchangeProgressLogic->getErrorMessage());
        }
        
        $status = $this->orderGoodsLogic->updateExchangeGoodsStatus($post);
        
        if (!$status) {
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
    public function courierNumberByShopMGBd(Request $req): array
    {
       
        $post = $req->post();
        
        $ret = $this->logic->setCourierNumber($post);

        if (false === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        return AjaxReturn::sendData('');
    }

    /**
     * 申请售后列表
     * @RequestMapping(route="progressQueryList", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function progressQueryListByShopMGTp(Request $req): array
    {
        return AjaxReturn::sendData([]);
        
    }

    /**
     * 申请售后进度查询
     * @RequestMapping(route="progressQuery", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function progressQueryByShopMGPa(Request $req): array
    {
        return AjaxReturn::sendData([]);
    }

    /**
     * 查询订单
     * @RequestMapping(route="searchOrder", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function searchOrderByShopMGHd(Request $req): array
    {
        return AjaxReturn::sendData([]);
    }
}