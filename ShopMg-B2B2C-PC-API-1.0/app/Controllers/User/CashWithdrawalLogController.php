<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\CashWithDrawalLogic;
use App\Models\Logic\Specific\PayTypeLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 提现
 *
 * @author Administrator
 * @Controller(perfix="cashWithdrawalLog")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class CashWithdrawalLogController
{

    /**
     * @Inject()
     *
     * @var CashWithDrawalLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var PayTypeLogic
     */
    private $payTypeLogic;

    /**
     * 提现日志
     * @RequestMapping(route="cashBehavior", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function cashBehaviorByShopMGAb(Request $req): array
    {
        $data = $this->logic->getParseDataByList($req->post());

        if (0 === count($data['data'])) {
            return AjaxReturn::error('没有记录');
        }

        $data['data'] = $this->payTypeLogic->gePayNameByCash($data['data'], $this->logic->getSplitKeyByPay());

        return AjaxReturn::sendData($data);
    }
}
