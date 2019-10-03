<?php

/*
 * This file is part of Swoft.
 * (c) Swoft <group@swoft.org>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'consul' => [
        'address' => '127.0.0.1',
        'port'    => 8500,
        'register' => [
            'id'                => 'user1',
            'name'              => 'user',
            'tags'              => ['master'],
            'enableTagOverride' => false,
            'service'           => [
                'address' => '127.0.0.1',
                'port'   => '8099',
            ],
            'check'             => [
                'id'       => 'user1',
                'name'     => 'user',
                'tcp'      => 'http://127.0.0.1:8500/healthcheck',
                'interval' => 10,
                'timeout'  => 1,
            ],
        ],
        'discovery' => [
            'name' => 'user',
            'dc' => 'dc1',
            'near' => '',
            'tag' =>'master',
            'passing' => true
        ]
    ],
];