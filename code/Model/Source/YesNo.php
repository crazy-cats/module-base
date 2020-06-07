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
class YesNo extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    public function __construct()
    {
        $this->sourceData = [
            __('Yes') => '1',
            __('No')  => '0',
        ];
    }
}
