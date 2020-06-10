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
    'settings'  => [
        'general' => [
            'label'      => 'General',
            'scopes'     => ['global'],
            'sort_order' => 1,
            'fields'     => [
                'timezone'          => [
                    'label'  => 'Timezone',
                    'scopes' => ['global'],
                    'type'   => 'select',
                    'source' => 'CrazyCat\Base\Model\Source\TimeZones'
                ],
                'allowed_languages' => [
                    'label'  => 'Allowed Languages',
                    'scopes' => ['global'],
                    'type'   => 'multiselect',
                    'source' => 'CrazyCat\Base\Model\Source\Languages'
                ],
                'default_language'  => [
                    'label'  => 'Default Languages',
                    'scopes' => ['global'],
                    'type'   => 'select',
                    'source' => 'CrazyCat\Base\Model\Source\Languages'
                ]
            ]
        ],
        'website' => [
            'label'      => 'Website',
            'scopes'     => ['global', 'stage'],
            'sort_order' => 2,
            'fields'     => [
                'theme'                    => [
                    'label'  => 'Theme',
                    'scopes' => ['global', 'stage'],
                    'type'   => 'select',
                    'source' => 'CrazyCat\Base\Model\Source\Themes'
                ],
                'default_page_title'       => [
                    'label'  => 'Default Page Title',
                    'scopes' => ['global', 'stage'],
                    'type'   => 'text'
                ],
                'default_meta_keywords'    => [
                    'label'  => 'Default Meta Keywords',
                    'scopes' => ['global', 'stage'],
                    'type'   => 'text'
                ],
                'default_meta_description' => [
                    'label'  => 'Default Meta Description',
                    'scopes' => ['global', 'stage'],
                    'type'   => 'textarea'
                ],
                'default_meta_robots'      => [
                    'label'  => 'Default Robots',
                    'scopes' => ['global', 'stage'],
                    'type'   => 'select',
                    'source' => 'CrazyCat\Base\Model\Source\MetaRobots'
                ]
            ]
        ]
    ],
    'setup'     => [
        'CrazyCat\Base\Setup\Install'
    ]
];
