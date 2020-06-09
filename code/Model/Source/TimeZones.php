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
class TimeZones extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    public function __construct(
        \CrazyCat\Framework\Utility\Timezone $timezone
    ) {
        $this->sourceData = array_flip($timezone->zones());
    }
}
