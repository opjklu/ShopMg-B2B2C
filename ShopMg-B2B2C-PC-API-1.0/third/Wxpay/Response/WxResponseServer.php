<?php
// +----------------------------------------------------------------------
// | Electronic Commerce [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 www.shopqorg.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 上海米糕网络（http://www.shopqorg.com）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <13052079525>
// +----------------------------------------------------------------------
namespace Wxpay\Response;

use Wxpay\WxPayPubHelper;

/**
 * 响应型接口基类
 */
class WxResponseServer extends WxPayPubHelper
{

    private $data;
    // 接收到的数据，类型为关联数组
    private $returnParameters;
    // 返回参数，类型为关联数组
    
    /**
     * 将微信的请求xml转换成关联数组，以方便数据处理
     */
    function saveData($xml)
    {
        $this->data = $this->xmlToArray($xml);
    }

    function checkSign()
    {
        $tmpData = $this->data;
        unset($tmpData['sign']);
        $sign = $this->getSign($tmpData); // 本地签名
        if ($this->data['sign'] == $sign) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 获取微信的请求数据
     */
    function getData()
    {
        return $this->data;
    }

    /**
     * 设置返回微信的xml数据
     */
    function setReturnParameter($parameter, $parameterValue)
    {
        $this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }

    /**
     * 生成接口参数xml
     */
    function createXml()
    {
        return $this->arrayToXml($this->returnParameters);
    }

    /**
     * 将xml数据返回微信
     */
    function returnXml()
    {
        $returnXml = $this->createXml();
        return $returnXml;
    }
}