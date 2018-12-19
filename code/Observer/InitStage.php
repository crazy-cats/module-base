<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Observer;

use CrazyCat\Core\Model\DbConfig;
use CrazyCat\Core\Model\Stage\Manager as StageManager;
use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Config;
use CrazyCat\Framework\App\Cookies;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class InitStage {

    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    /**
     * @var \CrazyCat\Framework\App\Cookies
     */
    private $cookies;

    /**
     * @var \CrazyCat\Core\Model\DbConfig
     */
    private $dbConfig;

    /**
     * @var \CrazyCat\Core\Model\Stage\Manager
     */
    private $stageManager;

    public function __construct( Cookies $cookies, StageManager $stageManager, DbConfig $dbConfig, Config $config )
    {
        $this->config = $config;
        $this->cookies = $cookies;
        $this->dbConfig = $dbConfig;
        $this->stageManager = $stageManager;
    }

    /**
     * @return void
     */
    public function execute( $observer )
    {
        if ( ( $stageCode = $observer->getAction()->getRequest()->getParam( 'stage', $this->cookies->getData( 'stage' ) ) ) ) {
            $this->stageManager->setCurrentStageCode( $stageCode );
        }
        $this->config->addData( [ Area::CODE_FRONTEND => $this->dbConfig->getConfigurations( Area::CODE_FRONTEND, $this->stageManager->getCurrentStage()->getId() ) ] );
    }

}
