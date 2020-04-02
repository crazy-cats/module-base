<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend\Config;

use CrazyCat\Base\Model\DbConfig;
use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Component\Module\Controller\Backend\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link https://crazy-cat.cn
 */
class Index extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction {

    /**
     * @var \CrazyCat\Base\Model\DbConfig
     */
    protected $dbConfig;

    public function __construct( DbConfig $dbConfig, Context $context )
    {
        parent::__construct( $context );

        $this->dbConfig = $dbConfig;
    }

    /**
     * @return array
     */
    protected function getConfigurations()
    {
        list( $scope, $scopeId ) = array_pad( explode( '-', $this->request->getParam( 'scope', Area::CODE_GLOBAL ) ), 2, 0 );

        return $this->dbConfig->getConfigurations( $scope, $scopeId );
    }

    protected function run()
    {
        $this->registry->register( 'configurations', $this->getConfigurations() );

        $this->setPageTitle( __( 'Configuration' ) )->render();
    }

}
