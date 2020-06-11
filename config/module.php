<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
return [
    'namespace' => 'CrazyCat\Base',
    'depends'   => [],
    'routes'    => [
        'cli'      => 'system',
        'backend'  => 'system',
        'frontend' => 'index'
    ],
    'setup'     => [
        'CrazyCat\Base\Setup\Install'
    ]
];
