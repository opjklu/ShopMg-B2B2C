<?php
declare(strict_types = 1);

namespace Pay\Component;


use Alipay\Aop\Request\AlipayTradePagePayRequest;
use Tool\Tool;

/**
 * 请求构造参数
 * @author Administrator
 */
trait RequestBuilderByRechargeTrait
{
	private $orderData = [];
	
	private $config = [];
	
	private $param = [];
	
	/**
	 * 获取支付请求数据
	 * @param string $body
	 * @param string $subject
	 * @return AlipayTradeWapPayContentBuilder
	 */
	private function getRequstBuilder(array $post)
	{
		
		$token = $this->config['token'];
		
		$config = $this->config;
		
		unset($config['token']);
		
		session()->put('pay_config_by_user', $config);
		
		$config = [
			'product_code' => 'FAST_INSTANT_TRADE_PAY',
			'out_trade_no' => Tool::connect('Token')->toGUID(),
			'passback_params' => json_encode(['token' => $token], JSON_UNESCAPED_UNICODE),
			'total_amount' => $post['money']
		];
		
		$config = array_merge($config, $this->param);
		
		$payRequestBuilder = new AlipayTradePagePayRequest();
		
		$payRequestBuilder->setReturnUrl($this->config['return_url']);
		
		$payRequestBuilder->setNotifyUrl($this->config['notify_url']);
		
		$payRequestBuilder->setBizContent(json_encode($config, JSON_UNESCAPED_UNICODE));
		
		return $payRequestBuilder;
	}
	
}