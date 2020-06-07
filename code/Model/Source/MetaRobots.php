<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model\Source;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class MetaRobots extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    public function __construct()
    {
        $this->sourceData = [
            'INDEX, FOLLOW'     => 'INDEX, FOLLOW',
            'INDEX, NOFOLLOW'   => 'INDEX, NOFOLLOW',
            'NOINDEX, FOLLOW'   => 'NOINDEX, FOLLOW',
            'NOINDEX, NOFOLLOW' => 'NOINDEX, NOFOLLOW'
        ];
    }
}
