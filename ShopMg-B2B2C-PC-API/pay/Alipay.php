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
declare(strict_types = 1);

namespace Pay;
use Pay\Component\PayTrait;
use Tool\Tool;
use Alipay\Aop\AopClient;
use Alipay\Aop\Request\AlipayTradePagePayRequest;

/**
 * 支付宝PC支付
 * @author Administrator
 */
class Alipay
{
	use PayTrait;
	
	private $config = [];
	
	private $orderData = [];
	
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
	public function pay(array $post) :array
	{
		$info = $this->orderData ;
		$priceSum = $this->totaMoney();
		
		if ($priceSum <= 0 || $this->isPass === false) {
			return [
				'data'=> '',
				'message'=>  '价格异常 或者 运费计算错误',
				'status'=>  0
			];
		}
		
		$payConfig = $this->config;
		
		$token = $payConfig['token'];
		
		unset($payConfig['token']);
		
		session()->put('pay_config_by_user', $payConfig);
		
		$payRequestBuilder = new AopClient();
		
		$payRequestBuilder->appId = $this->config['pay_account'];
		
		$payRequestBuilder->rsaPrivateKey = $this->config['private_pem'];
		
		$payRequestBuilder->signType = 'RSA2';
		
		$config = [
			'product_code' => 'FAST_INSTANT_TRADE_PAY',
			'subject'=> '多商户商品支付',
			'body' => 'OrderPay',
			'total_amount' => $priceSum,
		    'passback_params'=> json_encode(['token' => $token], JSON_UNESCAPED_UNICODE),
			'out_trade_no' => Tool::connect('Token')->toGUID(),
		];
		
		$payRequest = new AlipayTradePagePayRequest();
		
		$payRequest->setReturnUrl($this->config['return_url']);
		
		$payRequest->setNotifyUrl($this->config['notify_url']);
		
		$payRequest->setBizContent(json_encode($config, JSON_UNESCAPED_UNICODE));
		
		$result=$payRequestBuilder->pageExecute($payRequest);
		
		return [
			'data' =>$result,
			'message' => '成功',
			'status' => 1
		];
	}
}