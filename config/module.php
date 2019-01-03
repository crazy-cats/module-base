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
        'set_area_code_after' => 'CrazyCat\Core\Observer\PrepareForArea',
        'verify_api_token' => 'CrazyCat\Core\Observer\VerifyApiToken',
        'themes_init_after' => 'CrazyCat\Core\Observer\PrepareTheme',
        'page_render_before' => 'CrazyCat\Core\Observer\PrepareForRender'
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
                    'source' => 'CrazyCat\Core\Model\Source\TimeZones'
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
        ],
        'website' => [
            'label' => 'Website',
            'sort_order' => 2,
            'fields' => [
                'default_page_title' => [
                    'label' => 'Default Page Title',
                    'type' => 'text'
                ],
                'default_meta_keywords' => [
                    'label' => 'Default Meta Keywords',
                    'type' => 'text'
                ],
                'default_meta_description' => [
                    'label' => 'Default Meta Description',
                    'type' => 'textarea'
                ],
                'default_meta_robots' => [
                    'label' => 'Default Robots',
                    'type' => 'select',
                    'source' => 'CrazyCat\Core\Model\Source\MetaRobots'
                ]
            ]
        ]
    ]
];
