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
use App\Models\Logic\OrderWxpayLogic;
use Wxpay\WxPayConfPub;
use Wxpay\Pay\UnifiedOrderPub;
use Pay\Wx\ParseWx;

/**
 * 微信h5支付
 * @author 米糕网络团队
 */
class WxPay
{
	
	private $config = [];
	
	private $orderData = [];
	
	use PayTrait;
	
	/**
	 * 构造方法
	 */
	public function __construct(array $config = [], array $orderData = [])
	{
		$this->config = $config;
	
		$this->orderData = $orderData;
	}
	
	
	/**
	 * 微信支付
	 * @param OrderWxpayLogic $logic
	 */
	public function pay(array $post) :array
	{
		$info = $this->orderData ;
		
		$priceSum = $this->totaMoney();
		
		if ($priceSum <= 0 || $this->isPass === false) {
			return [
				'data'=> '',
				'message'=>  '价格异常 或者 运费计算错误 价格必须大于0',
				'status'=>  0
			];
		}
		
		
		$orderWxId = ParseWx::parse($info, (int)$this->config['special_status']);
		
		if ($orderWxId === '') {
			return [
				'data'=> '',
				'message'=>  '微信订单号生成异常',
				'status'=>  0
			];
		}
		
		$payConfig = $this->getPayConfig($this->config);
		
		$urlNofity = WxPayConfPub::$NOTIFY_URL ;
		
		$unifiedOrderPub = new UnifiedOrderPub();

		$config = $this->config;
		
		/**
		 * @var Ambigous <mixed, object, \Swoft\Aop\AopInterface> $configObj
		 */
		$configObj = \Swoft\App::getBean('config');
		
		$remoteAddr = $configObj->get('local_ip');
		
		$token = $config['token'];
		
		unset($config['token']);
		
		session()->put('pay_config_by_user', $config);
		
		//自定义参数
		$unifiedOrderPub->setParameter("body", "商品支付"); // 商品描述
		$unifiedOrderPub->setParameter("out_trade_no", $orderWxId); // 商户订单号
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
				'status'  => '0',
				'data'    => '',
			];
		} elseif ($unifiedOrderResult["result_code"] == "FAIL") {
			// 商户自行增加处理流程
			return [
				'message'=> '错误代码：' . $unifiedOrderResult['err_code'] . '错误代码描述：' . $unifiedOrderResult['err_code_des'],
				'status'=> '0',
				'data'=> ''
			];
		}
		
		$orderIdString = implode(',', array_column($info, 'order_id'));
		
		$callBackURL =  $configObj->get('call_back_wx');
		
		return[
			'status'=> 1,
			'data'=> [
				'code_url' => $unifiedOrderResult['code_url'],
				'order_sn' => $orderWxId,
				'order_id' => $orderIdString,
				'callback_url' => $callBackURL[$config['special_status']],
			],
			'message'=> '成功'
		];
	}
	
	public function __destruct()
	{
		unset( $this->config, $this->orderData);
	}
}