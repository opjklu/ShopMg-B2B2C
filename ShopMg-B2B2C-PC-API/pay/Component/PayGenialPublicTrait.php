<?php
declare(strict_types = 1);

namespace Pay\Component;


use Wxpay\Pay\UnifiedOrderPub;
use Wxpay\WxPayConfPub;

/**
 * 支付公共组件
 * @author Administrator
 *
 */
trait PayGenialPublicTrait
{
	
	/**
	 * 支付订单数据
	 * @var array
	 */
	private $orderData = [];
	
	/**
	 * 数据配置
	 * @var array
	 */
	private $config = [];
	
	
	/**
	 * 商品描述
	 * @var string
	 */
	private $description = '';
	
	
	/**
	 * 支付组件
	 * @param float $money
	 * @return string[]|number[]|string[]|string[][]|number[][]|mixed[][]
	 */
	private function component(float $priceSum, string $orderSnId) :array
	{
		$unifiedOrderPub = new UnifiedOrderPub();
		
		$urlNofity = WxPayConfPub::$NOTIFY_URL ;
		
		$token = $this->config['token'];
		
		$config = $this->config;
		
		unset($config['token']);
		
		session()->put('pay_config_by_user', $config);
		
		/**
		 * @var Ambigous <mixed, object, \Swoft\Aop\AopInterface> $configObj
		 */
		$configObj = \Swoft\App::getBean('config');
		
		$remoteAddr = $configObj->get('local_ip');
		
		$unifiedOrderPub->setParameter("body", $this->description); // 商品描述
		$unifiedOrderPub->setParameter("out_trade_no", $orderSnId); // 商户订单号
		$unifiedOrderPub->setParameter("total_fee", $priceSum * 100); // 总金额
		$unifiedOrderPub->setParameter("notify_url", $urlNofity); // 通知地址
		$unifiedOrderPub->setParameter("trade_type", "NATIVE"); // 交易类型
		$unifiedOrderPub->setParameter("attach", $token);
		$unifiedOrderPub->setParameter('remote_addr', $remoteAddr);
		
		// 获取统一支付接口结果
		$unifiedOrderResult = $unifiedOrderPub->getResult();
		
		// 商户根据实际情况设置相应的处理流程
		if ($unifiedOrderResult["return_code"] == "FAIL") {
			// 商户自行增加处理流程
			return [
				'message' =>'通信出错：' . $unifiedOrderResult['return_msg'],
				'status'  => 0,
				'data'    => '',
			];
		} elseif ($unifiedOrderResult["result_code"] == "FAIL") {
			// 商户自行增加处理流程
			return [
				'message'=> '错误代码：' . $unifiedOrderResult['err_code'] . '错误代码描述：' . $unifiedOrderResult['err_code_des'],
				'status'=> 0,
				'data'=> ''
			];
		}
		
		$callBackURL = $configObj->get('call_back_wx');
		
		return[
			'status'=> 1,
			'data'=> [
				'code_url' => $unifiedOrderResult['code_url'],
				'order_sn' =>  $orderSnId,
				'order_id' => $this->orderData['order_id'],
				'callback_url' => $callBackURL[$config['special_status']],
			],
			'message'=> '成功'
		];
	}
	
	public function __destruct()
	{
	    $this->config = [];
	    
	    $this->description = '';
	    
	    $this->orderData = [];
	}
}