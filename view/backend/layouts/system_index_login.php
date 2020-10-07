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
    'template' => 'home',
    'blocks'   => [
        'main' => [
            'children' => [
                'login' => [
                    'class' => 'CrazyCat\Base\Block\Template',
                    'data'  => ['template' => 'CrazyCat\Base::login']
                ]
            ]
        ]
    ]
];
