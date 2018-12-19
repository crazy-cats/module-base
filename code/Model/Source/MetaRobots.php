<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Model\Source;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class MetaRobots extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    public function __construct()
    {
        $this->sourceData = [
            'INDEX, FOLLOW' => 'INDEX, FOLLOW',
            'INDEX, NOFOLLOW' => 'INDEX, NOFOLLOW',
            'NOINDEX, FOLLOW' => 'NOINDEX, FOLLOW',
            'NOINDEX, NOFOLLOW' => 'NOINDEX, NOFOLLOW'
        ];
    }

}
