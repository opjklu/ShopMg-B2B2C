<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

use App\Models\Logic\Specific\OpenShopOrderLogic;
use Swoft\Bean\Annotation\Inject;
use Swoft\Log\Log;
use Tool\Hook;

/**
 * 开店回调组件
 *
 * @author Administrator
 *
 */
trait OpenShopTrait
{

    /**
     * @Inject()
     *
     * @var OpenShopOrderLogic
     */
    private $logic;

    private $errorMessage;

    /**
     * 开店回调
     *
     * @param string $tradeNo
     *            支付宝流水号
     * @return bool
     */
    private function opShopNofity(string $listener, string $tradeNo = ''): bool
    {
        $orderData = session()->get('order_data_by_open_shop');

        $config = session()->get('pay_config_by_user');

        $reslut = [
            'order_id' => $orderData['order_id'],
            'pay_id' => $config['pay_type_id'],
            'platform' => $config['type']
        ];

        $status = $this->logic->saveStatus($reslut);

        if ($status === false) {

            Log::error('开店订单修改----' . $status, $reslut);

            return false;
        }

        $param = [
            'order_sn_id' => $orderData['order_id'],
            'trade_no' => $tradeNo,
            'wx_order_id' => $orderData['order_id'],
            'type' => 3
        ];

        Hook::listen('aplipayBalanceSerial', $param);

        if (0 === count($param)) {
            Log::error('---回调开店---错误', $param);

            return false;
        }

        $storeData = session()->get('store_data_by_person');

        if (empty($storeData)) {
            Log::error('---开店修改支付状态失败---');
        }

        Hook::listen($listener, $storeData);

        if (empty($storeData)) {

            Log::error('---回调开店订单修改失败---');

            return false;
        }

        session()->remove('store_data_by_person');

        session()->remove('order_data_by_open_shop');

        session()->remove('pay_config_by_user');

        return true;
    }
}