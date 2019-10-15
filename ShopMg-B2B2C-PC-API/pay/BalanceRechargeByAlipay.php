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

use Pay\Component\RequestBuilderByRechargeTrait;
use Pay\Component\AlipayTradeServiceTrait;

/**
 * 余额充值
 * @author Administrator
 */
class BalanceRechargeByAlipay
{
	use RequestBuilderByRechargeTrait;
	use AlipayTradeServiceTrait;
	
	
	/**
	 * 架构方法
	 * @param array $config
	 * @param array $orderData
	 */
	public function __construct(array $config = [], array $orderData = [])
	{
		$this->config = $config;
	
		$this->orderData = $orderData;
	}
	
	
	/**
	 * 支付宝支付
	 */
	public function pay(array $post)
	{
		$this->param = [
			'body' => 'RechargePay',
			'subject' => '余额充值',
		];
		
		session()->put('order_data_by_balance', $this->orderData);
		
		$payRequst = $this->getRequstBuilder($post);
		
		$this->alipayConfig = $this->config;
		
		$result = $this->getAlipayTrade($payRequst);
		
		return $result;
	}
}