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
    'template' => '2columns_left',
    'blocks' => [
        'header' => [
                [ 'class' => 'CrazyCat\Core\Block\Template', 'data' => [
                    'template' => 'CrazyCat\Core::header_buttons',
                    'buttons' => [
                        'new' => [ 'label' => __( 'Create New' ), 'action' => [ 'type' => 'redirect', 'params' => [ 'url' => getUrl( 'appfront/view/edit' ) ] ] ]
                    ]
                ] ]
        ],
        'main' => [
                [ 'class' => 'CrazyCat\Core\Block\Backend\Stage\Grid' ]
        ]
    ]
];
