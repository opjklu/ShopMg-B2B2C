<?php
namespace Pay;

use App\Models\Logic\Specific\OrderWxpayLogic;
use Pay\Component\PayTrait;
use Pay\Component\PayGenialPublicTrait;
use Swoft\App;

/**
 * 开店支付费用（微信）
 * @author Administrator
 */
class OpenShopByWxPay
{
	use PayTrait;
	
	use PayGenialPublicTrait;
	
	
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
		
		$this->description = '开店支付';
	}
	
	/**
	 * 微信支付
	 */
	public function pay() :array
	{
		$storeData = session()->get('store_data_by_person');

		if (!$storeData) {
			return [
				'data'=> '',
				'message'=>  '充值金额异常 ',
				'status'=>  '0'
			];
		}
		$info = $this->orderData ;
		
		$priceSum = $info['money'];
		
		if ($priceSum <= 0) {
			return [
				'data'=> '',
				'message'=>  '充值金额异常 ',
				'status'=>  '0'
			];
		}

		$this->orderData['pay_type'] = 3;
		
		$wxOrderId = App::getBean(OrderWxpayLogic::class)->getResultByPay($this->orderData);
		
		if ('' == $wxOrderId) {
			return [
				'data'=> '',
				'message'=> '微信订单号生成异常',
				'status'=>  '0'
			];
		}
		
		$this->getPayConfig($this->config);
		

		SessionGet::getInstance('order_data_by_open_shop', $info)->set();
		

		$result = $this->component($priceSum, $wxOrderId);
		
		return $result;
	}
}