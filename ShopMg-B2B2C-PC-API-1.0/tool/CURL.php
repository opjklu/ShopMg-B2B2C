<?php
// +----------------------------------------------------------------------
// | OnlineRetailers [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2003-2023 wq.wq520wq.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed Wq（http://wq.wq520wq.cn）
// +----------------------------------------------------------------------
// | Author: 米糕网络团队 <opjklu@126.com>
// +----------------------------------------------------------------------
declare(strict_types = 1);
namespace Tool;


/**
 * curl 操作
 * 
 * @author Administrator
 * @version 1.0.1
 */
class CURL
{

    /**
     * 文件数组
     * 
     * @var array
     */
    private $data = [];

    /**
     * url
     * 
     * @var string
     */
    private $url = '';

    /**
     *
     * @param array $data            
     * @param string $url            
     */
    public function __construct(array $data, string $url)
    {
        $this->data = $data;
        
        $this->url = $url;
    }

    /**
     * 请求接口
     */
    public function requestQuery()
    {
        $data = $this->data;
        
        $url = $this->url;
        
        $returnData = $this->curlConfig();
        
        return $returnData;
    }

    /**
     *
     * @param array $data
     *            文件信息
     * @param string $url
     *            上传的URL
     */
    public function uploadFile()
    {
        $data = $this->data;
        
        $url = $this->url;
        
        if (empty($data) || empty($url)) {
            throw new \Exception('文件错误');
        }
        $data = [
            'data' => new \CURLFile(realpath($data['tmp_file']), $data['type'], $data['name'])
        ];
        
        $this->data = $data;
        
        $returnData = $this->curlConfig();
        return $returnData;
    }

    /**
     * 生成缩略图
     */
    public function sendImageToCreateThumb()
    {
        return $this->curlConfig();
    }

    private function curlConfig()
    {
        $url = $this->url;
        
        $data = $this->data;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $returnData = curl_exec($ch);
        curl_close($ch);
        return $returnData;
    }

    /**
     * 服务器获取信息
     * 
     * @return []
     */
    public function curlByGet()
    {
        $ch = curl_init();
        
        $url .= $this->url . '?' . http_build_query($this->data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);
        
        curl_close($ch);
        
        return $output;
    }

    /**
     * 删除文件
     */
    public function deleteFile()
    {
        return $this->curlConfig();
    }

    /**
     * 异步执行
     */
    public function asynchronousExecution(): void
    {
        $urlinfo = parse_url($this->url);
        
        $host = $urlinfo['host'];
        $path = $urlinfo['path'];
        $query = http_build_query($this->data);
        
        $port = 80;
        $errno = 0;
        $errstr = '';
        $timeout = 10;
        
        $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
        
        $out = "POST " . $path . " HTTP/1.1\r\n";
        $out .= "host:" . $host . "\r\n";
        $out .= "content-length:" . strlen($query) . "\r\n";
        $out .= "content-type:application/x-www-form-urlencoded\r\n";
        $out .= "connection:close\r\n\r\n";
        $out .= $query;
        
        fputs($fp, $out);
        fclose($fp);
    }

    public function __destruct()
    {
        $this->data = [];
        
        $this->url = '';
    }
}