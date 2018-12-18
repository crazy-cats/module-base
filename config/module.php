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
        'frontend_controller_execute_before' => 'CrazyCat\Core\Observer\InitStage',
        'verify_api_token' => 'CrazyCat\Core\Observer\VerifyApiToken',
        'themes_init_after' => 'CrazyCat\Core\Observer\PrepareForView'
    ],
    'routes' => [
        'backend' => 'system',
        'frontend' => 'index'
    ],
    'settings' => [
        'general' => [
            'label' => 'General',
            'sort_order' => 1,
            'fields' => [
                'timezone' => [
                    'label' => 'Timezone',
                    'type' => 'select',
                    'source' => 'CrazyCat\Core\Model\Source\Timezone'
                ],
                'allowed_languages' => [
                    'label' => 'Allowed Languages',
                    'type' => 'multiselect',
                    'source' => 'CrazyCat\Core\Model\Source\Languages'
                ],
                'default_language' => [
                    'label' => 'Default Languages',
                    'type' => 'select',
                    'source' => 'CrazyCat\Core\Model\Source\Languages'
                ]
            ]
        ]
    ]
];
