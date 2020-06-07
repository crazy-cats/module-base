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
    'themes_init_after'  => 'CrazyCat\Base\Observer\PrepareTheme',
    'page_render_before' => 'CrazyCat\Base\Observer\PrepareForRender'
];
