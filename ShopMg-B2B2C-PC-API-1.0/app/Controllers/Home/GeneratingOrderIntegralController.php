<?php
declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\Logic\Specific\OrderIntegralGoodsLogic;
use App\Models\Logic\Specific\OrderIntegralLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Tool\AjaxReturn;
use Tool\SessionManager;
use Validate\CheckParam;

/**
 * @Controller(perfix="generatingOrderIntegral")
 *
 * @author wq
 */
class GeneratingOrderIntegralController
{

    /**
     * @Inject()
     *
     * @var OrderIntegralLogic
     */
    private $logic;

    /**
     * @Inject()
     * @var OrderIntegralGoodsLogic
     */
    private $orderIntegralGoodsLogic;

    /**
     * 积分兑换处理 - 下订单
     * @RequestMapping(route="confirmExchange")
     */
    public function confirmExchangeByShopMGJm(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidateByBuildOrder(), $post);

        $status = $checkObj->detectionParameters();

        if (!$status) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        $payData = $this->logic->commitConfirm();

        if (0 === count($payData)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        $insertId = $payData[0]['order_id'];

        unset($payData[0]['order_id']);

        $status = $this->orderIntegralGoodsLogic->addOrderIntegral(['integral_order_id' => $insertId]);

        if(false === $status) {
            return AjaxReturn::error($this->orderIntegralGoodsLogic->getErrorMessage());
        }

        SessionManager::SET_ORDER_DATA($payData);

        SessionManager::REMOVE_GOODS_DATA_SOURCE();

        return AjaxReturn::sendData([
            'integral' => $payData[0]['integral'],
            'money' => $payData[0]['total_money']
        ]);
    }
}
