<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019-2039 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 米糕网络团队（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace App\Common\TraitClass;

use App\Models\Logic\Specific\BalanceLogic;
use App\Models\Logic\Specific\RechargeLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Log\Log;
use Tool\Hook;

trait BalanceParseTrait
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
     * @var BalanceLogic
     */
    private $balanceLogic;

    protected function parseByBalance(array $post): bool
    {
        // 防止恶意点击造成损失

        // $userId = session()->get('user_id');

        // $key = $userId.'_'.$this->tradeNo;

        // $result = Cache::getInstance('', ['expire' => 1440])->get($key);

        // $day = date('y_m');

        // if (!empty($result)) {
        // // 已经修改
        // return true;
        // }

        // 支付配置
        $payConfig = session()->get('pay_config_by_user');

        // 充值信息
        $orderRecharge = session()->get('order_data_by_balance');

        // 修改余额充值记录表
        $status = $this->logic->saveStatus($orderRecharge);

        if (!$status) {

            Log::error('修改余额充值记录表---result----修改余额充值记录表-');

            return false;
        }

        $param = [
            'order_sn_id' => $orderRecharge['order_id'],
            'trade_no' => $post['trade_no'],
            'wx_order_id' => $orderRecharge['order_id'],
            'type' => 4
        ];

        Hook::listen('aplipayBalanceSerial', $param);

        if (0 === count($param)) {

            Log::write('---修改支付状态--失败');

            return false;
        }

        $status = $this->balanceLogic->rechargeMoney([
            'total_amount' => $post['total_amount'],
            'trade_no' => $post['trade_no']
        ]);

        if (!$status) {
            Log::write('---修改充值订单---');

            return false;
        }
        return true;
    }
}