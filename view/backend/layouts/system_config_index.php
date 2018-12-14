<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
return [
    'template' => '2columns_left',
    'blocks' => [
        'header' => [
            'scopes' => [
                'class' => 'CrazyCat\Core\Block\Backend\Scopes'
            ],
            'buttons' => [
                'class' => 'CrazyCat\Core\Block\Template',
                'data' => [
                    'template' => 'CrazyCat\Core::header_buttons',
                    'buttons' => [
                        'save' => [ 'label' => __( 'Save' ), 'action' => [ 'type' => 'save', 'params' => [ 'target' => '#config-form' ] ] ],
                    ]
                ]
            ]
        ],
        'main' => [
            'main-content' => [ 'class' => 'CrazyCat\Core\Block\Backend\Config' ]
        ]
    ]
];
