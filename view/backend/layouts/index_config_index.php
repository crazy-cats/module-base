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
                [ 'class' => 'CrazyCat\Index\Block\Template', 'data' => [
                    'template' => 'CrazyCat\Index::header_buttons',
                    'buttons' => [
                        'save' => [ 'label' => __( 'Save' ), 'action' => [ 'type' => 'save', 'params' => [ 'target' => '#config-form' ] ] ],
                    ]
                ] ]
        ],
        'main' => [
                [ 'class' => 'CrazyCat\Index\Block\Backend\Config' ]
        ]
    ]
];
