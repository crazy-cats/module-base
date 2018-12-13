<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package CrazyCat\Index
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
return [
    'namespace' => 'CrazyCat\Index',
    'version' => '1.0.0',
    'depends' => [],
    'events' => [
        'controller_execute_before' => 'CrazyCat\Index\Observer\MergeDbConfig',
        'verify_api_token' => 'CrazyCat\Index\Observer\VerifyApiToken'
    ],
    'routes' => [
        'frontend' => 'index',
        'backend' => 'index'
    ]
];
