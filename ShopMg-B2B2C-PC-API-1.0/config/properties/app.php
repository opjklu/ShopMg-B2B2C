<?php

/*
 * This file is part of Swoft.
 * (c) Swoft <group@swoft.org>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'env'          => env('APP_ENV', 'test'),
    'debug'        => env('APP_DEBUG', true),
    'version'      => '1.0',
    'autoInitBean' => true,
    'bootScan'     => [
        'App\Commands',
        'App\Boot',
    ],
    'excludeScan'  => [
        'App\Helper',
    ],
    'translator'         => [
        'languageDir' => '@resources/languages/',
    ],
    'db'           => require __DIR__ . DS . 'db.php',
    'cache'        => require __DIR__ . DS . 'cache.php',
    'service'      => require __DIR__ . DS . 'service.php',
    'breaker'      => require __DIR__ . DS . 'breaker.php',
    'provider'     => require __DIR__ . DS . 'provider.php',
    'url_config' => require_once __DIR__ . DS . 'config.php',
    'origin' => [
        'http://pcweb.local.cn:8089',
        'https://api.mch.weixin.qq.com',
        'https://openapi.alipay.com',
        'http://pcweb.local.com:8089',
    ],
    'cookie_domain' => '.wq520wq.cn',
    //微信支付轮询查询是否支付成功
    'call_back_wx' => [
        'http://pc.local.com/OrderMake/isCheckPay',
        'http://pc.local.com/OrderPackageMake/isCheckPay',
        'http://pc.local.com/IntegralOrders/isCheckPay',
        'http://pc.local.com/OpenStoreSelect/isCheckPay',
        'http://pc.local.com/BalanceRecharge/isCheckPay'
    ],
    
    'local_ip' => '118.89.34.82',
    
    'MAIL_SUBJECT' => '沪上理想空间网络：邮箱验证',
    // 配置邮件发送服务器
    'MAIL_HOST' =>'smtp.126.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'',//你的邮箱名
    'MAIL_FROM' =>'@126.com',//发件人地址
    'MAIL_FROMNAME'=>'',//发件人姓名
    'MAIL_PASSWORD' =>'',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' => TRUE, // 是否HTML格式邮件
    'MAIL_SMTPSECURE' => 'tls', // Enable TLS encryption, `ssl` also accepted
    'MAIL_PORT' => 25,
];
