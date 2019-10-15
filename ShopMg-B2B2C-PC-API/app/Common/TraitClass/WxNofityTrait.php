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

use Swoft\Log\Log;
use Wxpay\Notify\NotifyCommonPub;

/**
 * 微信处理
 */
trait WxNofityTrait
{

    /**
     * 通知对象
     *
     * @var NotifyCommonPub
     */
    private $notify;

    /**
     * 获取自定义参数
     */
    private function getTheCustomParamter(string $xml): array
    {
        // 使用通用通知接口
        $notify = new NotifyCommonPub();

        // 存储微信的回调

        $notify->saveData($xml);

        $data = $notify->getData();

        if ($data["return_code"] == "FAIL") {

            Log::error('订单处理-return_code-支付失败--');

            return [];
        }

        $this->notify = $notify;

        $data['token'] = $data['attach'];

        unset($data['attach']);

        return $data;
    }

    /**
     * 通知
     */
    private function nofityWx(): bool
    {
        $isSign = $this->notify->checkSign();

        if ($isSign == FALSE) {

            $day = date('y_m');

            Log::error('微信签名失败--');

            return false;
        } else {
            return true;
        }
    }

    public function __destruct()
    {
        $this->notify = null;
    }
}

