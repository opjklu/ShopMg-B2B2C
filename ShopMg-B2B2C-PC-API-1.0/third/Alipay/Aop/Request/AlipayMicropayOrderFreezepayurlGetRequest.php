<?php
/**
 * Alipay API: Alipay.micropay.order.freezepayurl.get request
 *
 * @author auto create
 * @since 1.0, 2016-06-06 17:52:18
 */
class AlipayMicropayOrderFreezepayurlGetRequest
{
	/** 
	 * 冻结订单号,创建冻结订单时支付宝返回的
	 **/
	private $AlipayOrderNo;

	private $apiParas = array();
	private $terminalType;
	private $terminalInfo;
	private $prodCode;
	private $apiVersion="1.0";
	private $notifyUrl;
	private $returnUrl;
    private $needEncrypt=false;

	
	public function setAlipayOrderNo($AlipayOrderNo)
	{
		$this->AlipayOrderNo = $AlipayOrderNo;
		$this->apiParas["Alipay_order_no"] = $AlipayOrderNo;
	}

	public function getAlipayOrderNo()
	{
		return $this->AlipayOrderNo;
	}

	public function getApiMethodName()
	{
		return "Alipay.micropay.order.freezepayurl.get";
	}

	public function setNotifyUrl($notifyUrl)
	{
		$this->notifyUrl=$notifyUrl;
	}

	public function getNotifyUrl()
	{
		return $this->notifyUrl;
	}

	public function setReturnUrl($returnUrl)
	{
		$this->returnUrl=$returnUrl;
	}

	public function getReturnUrl()
	{
		return $this->returnUrl;
	}

	public function getApiParas()
	{
		return $this->apiParas;
	}

	public function getTerminalType()
	{
		return $this->terminalType;
	}

	public function setTerminalType($terminalType)
	{
		$this->terminalType = $terminalType;
	}

	public function getTerminalInfo()
	{
		return $this->terminalInfo;
	}

	public function setTerminalInfo($terminalInfo)
	{
		$this->terminalInfo = $terminalInfo;
	}

	public function getProdCode()
	{
		return $this->prodCode;
	}

	public function setProdCode($prodCode)
	{
		$this->prodCode = $prodCode;
	}

	public function setApiVersion($apiVersion)
	{
		$this->apiVersion=$apiVersion;
	}

	public function getApiVersion()
	{
		return $this->apiVersion;
	}

  public function setNeedEncrypt($needEncrypt)
  {

     $this->needEncrypt=$needEncrypt;

  }

  public function getNeedEncrypt()
  {
    return $this->needEncrypt;
  }

}
