<?php
use App\Middlewares\CorsMiddleware;
use App\Middlewares\SessionByMeMiddleware;

/*
 * This file is part of Swoft.
 * (c) Swoft <group@swoft.org>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'serverDispatcher' => [
        'middlewares' => [
            SessionByMeMiddleware::class,
            CorsMiddleware::class
        ]
    ],
    'httpRouter'       => [
        'ignoreLastSlash'  => false,
        'tmpCacheNumber' => 1000,
        'matchAll'       => '',
    ],
    'requestParser'    => [
        'parsers' => [

        ],
    ],
//     'view'             => [
//         'viewsPath' => '@resources/views/',
//     ],
    'cache'            => [
        'class' => \Swoft\Redis\Redis::class,
        'driver' => 'redis',
    ],
    'demoRedis' => [
        'class' => \Swoft\Redis\Redis::class,
        'poolName' => 'demoRedis'
    ],
    // ......
    'providerSelector' => [
        'class' => \Swoft\Sg\ProviderSelector::class,
        'provider' => 'consul',
        'providers' => [
            'consul' => \Swoft\Sg\Provider\ConsulProvider::class
        ]
    ],
    
    // 注意Bean大小写
    'sessionManager' => [
        'class' => \Swoft\Session\SessionManager::class,
        'config' => [
            'driver' => 'redis',
            'name' => 'SWOFT_SESSION_ID',
            'lifetime' => 1800,
            'expire_on_close' => false,
            'encrypt' => false,
        ],
    ],
];
