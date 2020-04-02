<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@com.com>
 * @link     https://crazy-cat.cn
 */
return [
    'namespace' => 'CrazyCat\Base',
    'version' => '1.0.0',
    'depends' => [],
    'routes' => [
        'cli' => 'system',
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
                    'source' => 'CrazyCat\Base\Model\Source\TimeZones'
                ],
                'allowed_languages' => [
                    'label' => 'Allowed Languages',
                    'type' => 'multiselect',
                    'source' => 'CrazyCat\Base\Model\Source\Languages'
                ],
                'default_language' => [
                    'label' => 'Default Languages',
                    'type' => 'select',
                    'source' => 'CrazyCat\Base\Model\Source\Languages'
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
                    'source' => 'CrazyCat\Base\Model\Source\MetaRobots'
                ]
            ]
        ]
    ]
];
