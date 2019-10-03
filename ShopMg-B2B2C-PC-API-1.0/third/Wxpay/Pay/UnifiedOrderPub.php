<?php
namespace Wxpay\Pay;
use Wxpay\Request\WxpayClientPub;
use Wxpay\WxPayConfPub as config;
use Wxpay\SDKRuntimeException;
/**
 * 统一支付接口类
 */
class UnifiedOrderPub extends WxpayClientPub
{
	function __construct(array $config = [], array $orderData = [])
    {
        //设置接口链接
        $this->url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        //设置curl超时时间
        $this->curl_timeout = config::CURL_TIMEOUT;
    }

    /**
     * 生成接口参数xml
     */
    function createXml()
    {
        try
        {
            //检测必填参数
            if($this->parameters['out_trade_no'] == null)
            {
                throw new SDKRuntimeException('缺少统一支付接口必填参数out_trade_no！'.'<br>');
            }elseif($this->parameters['body'] == null){
                throw new SDKRuntimeException('缺少统一支付接口必填参数body！'.'<br>');
            }elseif ($this->parameters['total_fee'] == null ) {
                throw new SDKRuntimeException('缺少统一支付接口必填参数total_fee！'.'<br>');
            }elseif ($this->parameters['notify_url'] == null) {
                throw new SDKRuntimeException('缺少统一支付接口必填参数notify_url！'.'<br>');
            }elseif ($this->parameters['trade_type'] == null) {
                throw new SDKRuntimeException('缺少统一支付接口必填参数trade_type！'.'<br>');
            }elseif ($this->parameters['trade_type'] == 'JSAPI' &&
                $this->parameters['openid'] == NULL){
                    throw new SDKRuntimeException('统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！'.'<br>');
            }
           
            $this->parameters['appid'] = config::$APPID_d;//公众账号ID
            $this->parameters['mch_id'] = config::$MCHID_d;//商户号
            $this->parameters['spbill_create_ip'] = $this->parameters['remote_addr'];//终端ip
            $this->parameters['nonce_str'] = $this->createNoncestr();//随机字符串
            unset($this->parameters['remote_addr']);
            $this->parameters['sign'] = $this->getSign($this->parameters);//签名
            
            return  $this->arrayToXml($this->parameters);
        }catch (SDKRuntimeException $e)
        {
            die($e->errorMessage());
        }
    }

    /**
     * 获取prepay_id
     */
    function getPrepayId()
    {
        $this->postXml();
        $this->result = $this->xmlToArray($this->response);
        $prepay_id = $this->result['prepay_id'];
        return $prepay_id;
    }
    
    /**
     * 获取公众号支付信息
     */
    public function genialPublicResult()
    {
    	$result = $this->getResult();
    	
    	// 商户根据实际情况设置相应的处理流程
    	if ($result['return_code'] == 'FAIL') {
    		// 商户自行增加处理流程
    		return [
    			'message' =>'通信出错：' . $result['return_msg'],
    			'status'  => '0',
    			'data'    => '',
    		];
    	} elseif ($result['result_code'] == 'FAIL') {
    		// 商户自行增加处理流程
    		return [
    			'message'=> '错误代码：' . $result['err_code'] . '错误代码描述：' . $result['err_code_des'],
    			'status'=> '0',
    			'data'=> ''
    		];
    	}
    	
    	$wxData = [
    		'appId' => $result['appid'],
    		'timeStamp' => time(),
    		'nonceStr' => $this->createNoncestr(),
    		'package'  => 'prepay_id='.$result['prepay_id'],
    		'signType' => 'MD5',
    	];
    	
    	ksort($wxData);
    	
    	$buff = '';
    	
    	foreach ($wxData as $key => $value) {
    		
    		if($key != 'sign' && $value != '' && !is_array($value)){
    			$buff .= $key . '=' . $value . '&';
    		}
    	}
    	
    	$buff = trim($buff, '&');
    	
    	$buff .= '&key='.config::$KEY_d;
    	
    	$buff = md5($buff);
    	
    	$buff = strtoupper($buff);
    	
    	$wxData['paySign'] = $buff;
    	
    	return[
    		'status'=> '1',
    		'data'=> $wxData,
    		'message'=> '成功'
    	];
    	
    }

}
