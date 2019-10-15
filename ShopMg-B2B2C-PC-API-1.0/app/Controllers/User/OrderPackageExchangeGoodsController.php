<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OrderPackageExchangeGoodsLogic;
use App\Models\Logic\Specific\OrderPackageExchangeProgressLogic;
use App\Models\Logic\Specific\OrderPackageGoodsLogic;
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
 * 套餐订单换货
 * @Controller(prefix="/orderPackageExchangeGoods")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class OrderPackageExchangeGoodsController
{
    /**
     * @Inject()
     *
     * @var OrderPackageExchangeGoodsLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var OrderPackageExchangeProgressLogic
     */
    private $orderPackageExchangeProgressLogic;
    
    
    /**
     * @Inject()
     *
     * @var OrderPackageGoodsLogic
     */
    private $orderPackageGoodsLogic;
    
    /**
     * 换货申请
     * @RequestMapping(route="customerService", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function customerServiceByShopMGAi(Request $req): array
    {
        $post = $req->post();
        
        $checkObj = new CheckParam($this->logic->getValidateByApply(), $post);
        
        if (false === $checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $ret = $this->logic->applyForAfterSale();

        if (0 === $ret) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $status = $this->orderPackageExchangeProgressLogic->addProcess(['insert_id' => $ret]);
        
        if (!$status) {
            return AjaxReturn::error($this->orderExchangeProgressLogic->getErrorMessage());
        }
        
        $status = $this->orderPackageGoodsLogic->updateExchangeGoodsStatus($post);
        
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
    public function courierNumberByShopMGNm(Request $req): array
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
    public function progressQueryListByShopMGWq(Request $req): array
    {
        return AjaxReturn::sendData([]);
        
    }

    /**
     * 申请售后进度查询
     * @RequestMapping(route="progressQuery", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function progressQueryByShopMGJl(Request $req): array
    {
        return AjaxReturn::sendData([]);
        
    }

    /**
     * 查询订单
     * @RequestMapping(route="searchOrder", method=RequestMethod::POST)
     * @param Request $req
     * @return array
     */
    public function searchOrderByShopMGNn(Request $req): array
    {
        return AjaxReturn::sendData([]);
    }
}