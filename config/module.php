<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
return [
    'namespace' => 'CrazyCat\Core',
    'version' => '1.0.0',
    'depends' => [],
    'events' => [
        'controller_execute_before' => 'CrazyCat\Core\Observer\MergeDbConfig',
        'verify_api_token' => 'CrazyCat\Core\Observer\VerifyApiToken',
        'theme_init_after' => 'CrazyCat\Core\Observer\InitStage'
    ],
    'routes' => [
        'backend' => 'system',
        'frontend' => 'index'
    ],
    'settings' => [
        'general' => [
            'label' => __( 'General' ),
            'sort_order' => 1,
            'fields' => [
                'timezone' => [
                    'label' => __( 'Timezone' ),
                    'type' => 'select',
                    'source' => 'CrazyCat\Core\Model\Source\Timezone'
                ]
            ]
        ]
    ]
];
