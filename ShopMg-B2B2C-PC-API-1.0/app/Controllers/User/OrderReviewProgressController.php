<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\OrderReviewProgressLogic;
use App\Models\Logic\Specific\StoreSellerLogic;
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
 * 【订单】售后查询
 *
 * @author Administrator
 * @Controller(perfix="orderReviewProgress")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class OrderReviewProgressController
{

    /**
     * @Inject()
     *
     * @var OrderReviewProgressLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var StoreSellerLogic
     */
    private $storeSellerLogic;

    /**
     * 申请售后进度查询
     * @RequestMapping(route="progressQuery", method={RequestMethod::POST})
     * @Number(name="return_id", min=1)
     */
    public function progressQueryByShopMGFc(Request $req): array
    {
        $ret = $this->logic->returnInfo($req->post());

        if (0 === count($ret)) {
            return AjaxReturn::error($this->logic->getErrorMessage());
        }

        // 获取审核人
        $ret = $this->storeSellerLogic->getSellerDataByStore($ret, $this->logic->getSplitKeyByApproval());

        return AjaxReturn::sendData($ret);
    }
}
