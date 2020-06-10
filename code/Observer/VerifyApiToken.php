<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Observer;

use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Config;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class VerifyApiToken
{
    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param \CrazyCat\Framework\Data\DataObject $observer
     * @throws \Exception
     */
    public function execute($observer)
    {
        $observer['verify_object']->setData(
            'token_validated',
            $observer['token'] == $this->config->getValue(Area::CODE_API)['token']
        );
    }
}
