<?php
declare(strict_types = 1);
namespace Pay;

use Pay\Component\PayTrait;
use Extend\Alipay\Aop\Request\AlipayFundTransToaccountTransferRequest;
use Extend\Alipay\Aop\AopClient;
use Common\Tool\Tool;

/**
 * 支付宝提现
 * @author Administrator
 */
class AlipayToAccountTransfer
{
	use PayTrait;
	
	private $error = '';
	
	private $data = [];
	
	public function __construct(array $payData, array $data)
	{
		//AlipaySubmit
		$this->data = $data;
		
		$this->payData = $payData;
		
	}
	
	/**
	 * @return the $error
	 */
	public function getError()
	{
		return $this->error;
	}
	
	/**
	 * 支付寶退款
	 */
	public function transfer() :array
	{
		
		// 获取支付宝配置
		$alipayConfig = $this->payData;
		
		if (empty($alipayConfig)) {
			$this->error = '支付数据错误';
			return [];
		}
		
		
		if ($this->data['money'] < 0) {
			
			$this->error = '金额错误';
			
			return [];
		}
		
		
		$requestBuilder = new AlipayFundTransToaccountTransferRequest();
		
		$param = [
			'out_biz_no' => Tool::connect('Token')->toGUID(),
			'payee_type' => 'ALIPAY_LOGONID',
			'payee_account' => $this->data['account'],
		    'amount' => $this->data['money'],
			'remark' => '提现'
		];
		
		$requestBuilder->setBizContent(json_encode($param, JSON_UNESCAPED_UNICODE));
		
		$aopClient = new AopClient();
		
		$aopClient->appId = $alipayConfig['pay_account'];
		
		$aopClient->rsaPrivateKey = $alipayConfig['private_pem'];
		
		$aopClient->signType = 'RSA2';
		
		$aopClient->alipayrsaPublicKey = $alipayConfig['public_pem'];
		
		//建立请求
		$res = $aopClient->execute($requestBuilder);
		
		if ($res->alipay_fund_trans_toaccount_transfer_response->code != 10000) {
			
		    $this->error = $res->alipay_fund_trans_toaccount_transfer_response->sub_msg;
			return [];
		}
		
		return (array)$res->alipay_fund_trans_toaccount_transfer_response;
	}
}