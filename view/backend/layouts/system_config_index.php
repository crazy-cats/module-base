<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
return [
    'template' => '2columns_left',
    'blocks'   => [
        'header' => [
            'children' => [
                'header-buttons' => [
                    'class' => 'CrazyCat\Base\Block\Template',
                    'data'  => [
                        'template' => 'CrazyCat\Base::header_buttons',
                        'buttons'  => [
                            'save' => [
                                'label'  => __('Save'),
                                'action' => [
                                    'type'   => 'save',
                                    'params' => ['target' => '#edit-form']
                                ]
                            ],
                        ]
                    ]
                ],
                'scopes'         => [
                    'class' => 'CrazyCat\Base\Block\Backend\Scopes'
                ]
            ]
        ],
        'main'   => [
            'children' => [
                'main-content' => [
                    'class' => 'CrazyCat\Base\Block\Backend\Config\Edit'
                ]
            ]
        ]
    ]
];
