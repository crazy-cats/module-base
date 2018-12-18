<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Observer;

use CrazyCat\Core\Model\DbConfig;
use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Config;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class MergeDbConfig {

    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    /**
     * @var \CrazyCat\Core\Model\DbConfig
     */
    private $dbConfig;

    public function __construct( DbConfig $dbConfig, Config $config )
    {
        $this->config = $config;
        $this->dbConfig = $dbConfig;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->config->addData( [ Area::CODE_GLOBAL => $this->dbConfig->getFromDb( Area::CODE_GLOBAL ) ] );
    }

}
