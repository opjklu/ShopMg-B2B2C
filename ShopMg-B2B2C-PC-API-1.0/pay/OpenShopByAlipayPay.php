<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed （http://www.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
// |简单与丰富！
// +----------------------------------------------------------------------
// |让外表简单一点，内涵就会更丰富一点。
// +----------------------------------------------------------------------
// |让需求简单一点，心灵就会更丰富一点。
// +----------------------------------------------------------------------
// |让言语简单一点，沟通就会更丰富一点。
// +----------------------------------------------------------------------
// |让私心简单一点，友情就会更丰富一点。
// +----------------------------------------------------------------------
// |让情绪简单一点，人生就会更丰富一点。
// +----------------------------------------------------------------------
// |让环境简单一点，空间就会更丰富一点。
// +----------------------------------------------------------------------
// |让爱情简单一点，幸福就会更丰富一点。
// +----------------------------------------------------------------------
namespace Pay;

use Pay\Component\AlipayTradeServiceTrait;
use Pay\Component\RequestBuilderByRechargeTrait;

/**
 * 支付宝开店支付
 * @author 米糕网络团队
 */
class OpenShopByAlipayPay
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
	 * 微信支付
	 */
	public function pay()
	{
		$data = $this->checkMoney();
		if (!empty($data)) {
			return $data;
		}
		
		$this->param = [
			'body' => 'OpenShop',
			'subject' => '开店支付'
		];
		
		session()->put('order_data_by_open_shop', $this->orderData);
		
		$payRequst = $this->getRequstBuilder();
		
		$this->alipayConfig = $this->config;
		
		$result = $this->getAlipayTrade($payRequst);
		
		return $result;
	}
	
	/**
	 * 获取自定义参数
	 */
	protected function getPassbackParamst(array $map)
	{
		$storeData = session()->get('store_data_by_person');
		
		$map['store_id'] = $storeData['id'];
		
		$map['store_type'] = $this->orderData['store_type'];
		
		return $map;
	}
}