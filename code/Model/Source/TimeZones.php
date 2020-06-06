<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model\Source;

use CrazyCat\Framework\Utility\Timezone;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class TimeZones extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource {

    public function __construct()
    {
        $this->sourceData = array_flip( Timezone::zones() );
    }

}
