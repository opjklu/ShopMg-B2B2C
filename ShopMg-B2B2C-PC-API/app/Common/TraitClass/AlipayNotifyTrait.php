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
namespace App\Common\TraitClass;

use Alipay\Wappay\Service\AlipayTradeService;
use Swoft\Log\Log;

/**
 * 支付宝回调验证
 */
trait AlipayNotifyTrait
{

    /**
     *
     * @param array $data
     *            支付宝数据
     * @return array|array
     */
    public function alipayResultParse(array $post): bool
    {
        $config = session()->get('pay_config_by_user');

        if (0 === count($config)) {

            Log::error('订单处理支付配置错误--', $post);

            return false;
        }

        $alipayConfig['app_id'] = $config['pay_account'];

        $alipayConfig['merchant_private_key'] = $config['private_pem'];

        $alipayConfig['alipay_public_key'] = $config['public_pem'];

        $alipayNotify = new AlipayTradeService($alipayConfig);

        $verifyResult = $alipayNotify->check($post);

        file_put_contents('./sign.txt', (bool)$verifyResult);

        if (!$verifyResult) {

            Log::error('支付宝check-sign-异常-', $post);

            return false;
        }
        return true;
    }

    /**
     *
     * @param array $data
     * @return array
     */
    private function parseResultConf(array $data): array
    {
        if ($data['trade_status'] != 'TRADE_FINISHED' && $data['trade_status'] != 'TRADE_SUCCESS') {

            Log::error('支付宝-支付失败-', $data);

            return [];
        }

        if (!isset($data['passback_params'])) {
            return [];
        }
        return json_decode($data['passback_params'], true);
    }

    private function msg($status): void
    {
        if (empty($status)) {
            echo 'ERROR';
            Log::error('参数-异常-', [
                print_r($status, true)
            ]);

            return;
        }
    }
}