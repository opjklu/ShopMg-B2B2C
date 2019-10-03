<?php
namespace Pay;

use Pay\Component\PayTrait;
use Pay\Component\PayGenialPublicTrait;
use App\Models\Logic\OrderWxpayLogic;
use Pay\Wx\ParseWx;

/**
 * 余额充值
 * @author Administrator
 */
class BalanceRechargeByWxPay 
{
	use PayTrait;
	
	use PayGenialPublicTrait;
	
	/**
	 * 余额充值
	 * @var integer
	 */
	const BALANCE_RECHARGE = 4;
	
	/**
	 * 架构方法
	 * @param array $config
	 * @param array $orderData
	 */
	public function __construct(array $config = [], array $orderData = [])
	{
		$this->config = $config;
		
		$this->description = '余额充值';
		
		$this->orderData = $orderData;
	}

    /**
     * 微信支付
     * @param array $post
     * @return array|\mixed[][]|number[]|\number[][]|string[]|\string[][]
     */
	public function pay(array $post)
	{
		$info = $this->orderData ;
		
		$priceSum = $post['money'];
		
		if (bccomp($priceSum, 0.00, 2) === -1) {
			return [
				'data'=> '',
				'message'=> '充值金额异常 ',
				'status'=> '0'
			];
		}
		
		$info['pay_type'] =  static::BALANCE_RECHARGE;
		
		$wxOrderId = ParseWx::parseBalance($info);
		
		if ($wxOrderId === '') {
			return [
				'data'=> '',
				'message'=>  '微信订单号生成异常',
				'status'=>  '0'
			];
		}
		
		$this->getPayConfig($this->config);
		
		session()->put('order_data_by_balance', $info);
		
		$result = $this->component((float)$priceSum, $wxOrderId);
		
		return $result;
	}
}