<?php
declare(strict_types = 1);

namespace Tool;
/**
 * ajax 组装数据
 * @author Administrator
 *
 */
class AjaxReturn
{
    public static function sendData($data, string $message = '成功') :array
    {
        return [
            'data' => $data,
            'status' => 1, 
            'message' => $message
        ];
    }
    
    /**
     * 
     * @param string $message
     * @return array
     */
    public static function error(string $message) :array
    {
        return [
            'data' => '',
            'status' => 0,
            'message' => $message
        ];
    }
}