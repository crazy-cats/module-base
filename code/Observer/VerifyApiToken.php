<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Observer;

use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Config;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class VerifyApiToken {

    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    public function __construct( Config $config )
    {
        $this->config = $config;
    }

    /**
     * @param \CrazyCat\Framework\Data\DataObject $observer
     */
    public function execute( $observer )
    {
        $observer['verify_object']->setData( 'token_validated', $observer['token'] == $this->config[Area::CODE_API]['token'] );
    }

}
