<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed （http://www.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------

namespace Pay;

use Home\Model\OrderModel;
use PlugInUnit\UpacpApp\SDK\AcpService;
use Common\Model\BaseModel;
use Common\Model\PayModel;
use Pay\Component\NoticeTrait;
use Pay\Component\PayTrait;

/**
 * 银联 
 */
class UnionPay extends AcpService
{
    use NoticeTrait;
    use PayTrait;

    /**
     * 银联支付 
     */
    public function pay($obj, $info = null) {
        
        if (!is_object($obj)) {
            throw new \Exception('参数错误');
        }
        
        if (empty($info[OrderModel::$orderSn_id_d])) {
            $obj->showMessage('参数错误');die();
        }
        if (empty($info[OrderModel::$priceSum_d]) || $info[OrderModel::$priceSum_d] < 0) {
            $obj->showMessage('参数错误');die();
        }
        
        $payModel = BaseModel::getInstance(PayModel::class);
         
        $data = $payModel->getPayInfo($info[OrderModel::$payType_d], $info[OrderModel::$platform_d]);
        
        if (empty($data)) {
            $obj->showMessage($data, '参数有误');
        }
        
        $config = C('UnionPay');

        if (empty($data)) {
            $obj->showMessage($data, '参数有误');
        }
        
        $config['merId']   = $data[PayModel::$payAccount_d];
        
        $config['orderId'] = $info[OrderModel::$orderSn_id_d];
        
        $config['txnAmt']  = $info[OrderModel::$priceSum_d] * 100;
        self::sign($config);
        $html = self::createAutoFormHtml($config, self::SDK_FRONT_TRANS_URL);
        die($html);
    }

}