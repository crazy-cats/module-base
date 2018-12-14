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
    'system/stage/index' => [
        'label' => __( 'Front Stage' ),
        'url' => getUrl( 'system/stage' ),
        'sort_order' => 3
    ],
    'system/config/index' => [
        'label' => __( 'Configuration' ),
        'url' => getUrl( 'system/config' ),
        'sort_order' => 998
    ],
    'system/index/logout' => [
        'label' => __( 'Logout' ),
        'url' => getUrl( 'system/index/logout' ),
        'sort_order' => 999
    ]
];