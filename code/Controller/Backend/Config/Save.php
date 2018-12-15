<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Controller\Backend\Config;

use CrazyCat\Core\Model\DbConfig;
use CrazyCat\Framework\App\Module\Controller\Backend\Context;
use CrazyCat\Framework\App\Module\Manager as ModuleManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Save extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    /**
     * @var \CrazyCat\Core\Model\DbConfig
     */
    protected $dbConfig;

    /**
     * @var \CrazyCat\Framework\App\Module\Manager
     */
    protected $moduleManager;

    public function __construct( DbConfig $dbConfig, ModuleManager $moduleManager, Context $context )
    {
        parent::__construct( $context );

        $this->dbConfig = $dbConfig;
        $this->moduleManager = $moduleManager;
    }

    protected function run()
    {
        try {
            list( $scope, $scopeId ) = array_pad( explode( '-', $this->request->getPost( 'scope' ) ), 2, 0 );
            $data = $this->request->getPost( 'data' );
            $this->dbConfig->saveConfig( $data, $scope, $scopeId );
            $this->messenger->addSuccess( __( 'Configurations saved successfully.' ) );
        }
        catch ( \Exception $e ) {
            $this->messenger->addError( $e->getMessage() );
        }

        $this->redirect( 'system/config' );
    }

}
