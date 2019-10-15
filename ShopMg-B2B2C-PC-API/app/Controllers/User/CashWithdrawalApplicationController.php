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
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Controllers\User;

use App\Middlewares\ValidateLoginMiddleware;
use App\Models\Logic\Specific\BalanceLogic;
use App\Models\Logic\Specific\CashWithDrawalLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Tool\AjaxReturn;
use Validate\CheckParam;

/**
 * 提现申请
 *
 * @author 米糕网络团队
 * @Controller(prefix="/cashWithdrawalApplication")
 * @Middleware(ValidateLoginMiddleware::class)
 */
class CashWithdrawalApplicationController
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
     * @var BalanceLogic
     */
    private $balanceLogic;

    /**
     * 申请提现
     * @RequestMapping(route="cashAppliation", method=RequestMethod::POST)
     */
    public function cashAppliationByShopMGLi(Request $req): array
    {
        $post = $req->post();

        $checkObj = new CheckParam($this->logic->getValidateByCash(), $post);

        if (!$checkObj->detectionParameters()) {
            return AjaxReturn::error($checkObj->getErrorMessage());
        }

        if ($this->balanceLogic->getBalanceMoney($post) < 0) {
            return AjaxReturn::error('余额不足');
        }

        if (!$this->logic->addData($post)) {
            return AjaxReturn::error('申请失败');
        }

        return AjaxReturn::sendData('');
    }
}
