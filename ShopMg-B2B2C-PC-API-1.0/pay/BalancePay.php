<?php
declare(strict_types = 1);

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

use Pay\Component\PayTrait;
use Pay\Recharge\ParseRecharge;

/**
 * 余额支付
 */
class BalancePay 
{
    use PayTrait;
    
    private $config = [];
    
    private $orderData = [];
    
    /**
     *
     */
    public function __construct(array $config = [], array $orderData = [])
    {
    	$this->config = $config;
    	
    	$this->orderData = $orderData;
    }
    
    /**
     * 余额支付
     */
    public function pay()
    {
    	$info = $this->orderData;
    	
        if (empty($info)) {
        	return [
        		'data'=> '',
        		'message'=>  '价格异常',
        		'status'=>  0
        	];
        }
        
        $result = ParseRecharge::getResult($info, '余额支付');
       
        if ($result['status'] == 0) {
        	return $result;
        }
        
        $config = $this->config;
        
        unset($config['token']);
        
       	session()->put('pay_config_by_user', $config);
        
        $result['data'] = $config['notify_url'];
        
        return $result;
    }
    
}
