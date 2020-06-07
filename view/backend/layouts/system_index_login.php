<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package  CrazyCat\Admin
 * @author   Bruce Z <152416319@qq.com>
 * @link     https://crazy-cat.cn
 */
return [
    'template' => 'home',
    'blocks'   => [
        'main' => [
            'login' => [
                'class' => 'CrazyCat\Base\Block\Template',
                'data'  => ['template' => 'CrazyCat\Base::login']
            ]
        ]
    ]
];
