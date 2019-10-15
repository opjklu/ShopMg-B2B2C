<?php
declare(strict_types = 1);
namespace Sms\Send;
use Sms\SignatureHelper;

/**
 * 阿里发送短信
 * @author 米糕网络团队
 */
class SendSmsByPhone
{
	private $accessKeyId = '';
	
	private $accessKeySecret = '';
	
	private $param = [];
	
	private $error = '';
	
	public function getError() :string
	{
		return $this->error;
	}
	
	public function __construct($accessKeyId, $accessKeySecret, array $param)
	{
		$this->accessKeyId = $accessKeyId;
		
		$this->accessKeySecret = $accessKeySecret;
		
		$this->param = $param;
	
	}
	
	/**
	 * 发送短信
	 */
	public function sendMsg() :array
	{
		// 初始化SignatureHelper实例用于设置参数，签名以及发送请求
		$helper = new SignatureHelper();
		
		// 此处可能会抛出异常，注意catch
		$content = $helper->request(
				$this->accessKeyId,
				$this->accessKeySecret,
				"dysmsapi.aliyuncs.com",
				array_merge($this->param, [
					"RegionId" => "cn-hangzhou",
					"Action" => "SendSms",
					"Version" => "2017-05-25",
				])
		);
	
		if ($content['Code'] != 'OK') {	
			$this->error = $content['Message'];
			return [];
		}
		
		return $content;
	}
	
	/**
	 * 
	 */
	public function __destruct()
	{
		unset($this->accessKeyId, $this->accessKeySecret, $this->param);
	}
	
}
   
