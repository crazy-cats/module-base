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
    'template' => '2columns_left',
    'blocks'   => [
        'header' => [
            'children' => [
                'header-buttons' => [
                    'class' => 'CrazyCat\Base\Block\Template',
                    'data'  => [
                        'template' => 'CrazyCat\Base::header_buttons',
                        'buttons'  => [
                            'new' => [
                                'label'  => __('Create New'),
                                'action' => [
                                    'type'   => 'redirect',
                                    'params' => ['url' => getUrl('system/stage/edit')]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'main'   => [
            'children' => [
                'gird-form' => [
                    'class' => 'CrazyCat\Base\Block\Backend\Stage\Grid'
                ]
            ]
        ]
    ]
];
