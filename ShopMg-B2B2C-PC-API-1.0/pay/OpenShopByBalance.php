<?php
declare(strict_types = 1);

namespace Pay;

use Pay\Component\PayTrait;
use Pay\Recharge\ParseRecharge;

/**
 * 开店支付费用（余额）
 * @author Administrator
 */
class OpenShopByBalance
{
	use PayTrait;
	
	private $config = [];
	
	private $orderData = [];
	
	/**
	 * 开店支付
	 * @var integer
	 */
	const OPEN_SHOP_PAY = 2;
	
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
	 * 微信支付
	 */
	public function pay()
	{
		$storeData = session()->get('store_data_by_person');
		
		if (empty($storeData)) {
			return [
					'data'=> '',
					'message'=>  '充值金额异常 ',
					'status'=>  0
			];
		}
		$info = $this->orderData ;
		
		$priceSum = $info['money'];
		
		if ($priceSum <= 0) {
			return [
					'data'=> '',
					'message'=>  '充值金额异常 ',
					'status'=>  0
			];
		}
		
		$result = ParseRecharge::openShopParse($info, '开店费用');
		
		if ($result['status'] == 0) {
			return $result;
		}
		
		session()->put('order_data_by_open_shop', $this->orderData);
		
		$ley = md5(base64_encode(time(). 'WQ').'_ddkf');
		
		
		$config = $this->config;
		
		$token = $config['token'];
		
		unset($config['token']);
		
		session()->put('pay_config_by_user', $config);
		
		session()->put('ley_user', $ley);
		
		$result['data'] = $config['notify_url'];
		
		$result['ley_user'] = $ley;
		
		return $result;
	}
}