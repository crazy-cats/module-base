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
use CrazyCat\Framework\App\Io\Http\Request as HttpRequest;
use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\App\Timezone;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class PrepareForArea {

    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    /**
     * @var \CrazyCat\Core\Model\DbConfig
     */
    private $dbConfig;

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    private $objectManager;

    public function __construct( ObjectManager $objectManager, Config $config, DbConfig $dbConfig )
    {
        $this->config = $config;
        $this->dbConfig = $dbConfig;
        $this->objectManager = $objectManager;
    }

    /**
     * @return void
     */
    public function execute( $observer )
    {
        $areaCode = $observer->getArea()->getCode();

        $this->config->addData( [ Area::CODE_GLOBAL => $this->dbConfig->getConfigurations() ] );

        if ( $areaCode == Area::CODE_FRONTEND || $areaCode == Area::CODE_BACKEND ) {

            if ( $areaCode == Area::CODE_FRONTEND ) {

                /* @var $cookies \CrazyCat\Framework\App\Cookies */
                $cookies = $this->objectManager->get( Cookies::class );

                /* @var $request \CrazyCat\Framework\App\Io\Http\Request */
                $request = $this->objectManager->get( HttpRequest::class );

                /* @var $stageManager \CrazyCat\Core\Model\Stage\Manager */
                $stageManager = $this->objectManager->get( StageManager::class );

                /**
                 * Initialize stage
                 */
                $stageManager->setCurrentStageCode( $request->getParam( 'stage', $cookies->getData( 'stage' ) ) );
                $this->config->addData( [ $areaCode => $this->dbConfig->getConfigurations( $areaCode, $stageManager->getCurrentStage()->getId() ) ] );
            }

            /* @var $timezone \CrazyCat\Framework\App\Timezone */
            $timezone = $this->objectManager->get( Timezone::class );

            /**
             * Initialize timezone
             */
            $timezone->setTimezone( new \DateTimeZone( $this->config->getValue( 'general/timezone' ) ) );
        }
    }

}
