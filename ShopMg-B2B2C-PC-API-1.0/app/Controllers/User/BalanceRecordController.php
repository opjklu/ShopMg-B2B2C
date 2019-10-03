<?php
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\PayTypeLogic;
use App\Models\Logic\Specific\RechargeLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Number;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;

/**
 * 余额记录
 *
 * @author Administrator
 * @Controller(perfix="balanceRecord")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class BalanceRecordController
{

    /**
     * @Inject()
     *
     * @var RechargeLogic
     */
    private $logic;

    /**
     * @Inject()
     *
     * @var PayTypeLogic
     */
    private $payTypeLogic;

    /**
     * 余额充值记录列表
     * @RequestMapping(route="getBalanceList", method=RequestMethod::POST)
     * @Number(name="page", min=1)
     */
    public function getBalanceListByShopMGKl(Request $req): array
    {
        $data = $this->logic->getParseDataByList($req->post());

        if (0 === count($data['data'])) {
            return AjaxReturn::error('暂无数据');
        }

        $data['data'] = $this->payTypeLogic->gePayNameByCash($data['data'], $this->logic->getSplitKeyByPayType());

        return AjaxReturn::sendData($data);
    }
}
