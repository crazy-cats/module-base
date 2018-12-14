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
class Index extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

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

    /**
     * @return array
     */
    protected function getConfigurations()
    {
        list( $scope, $scopeId ) = array_pad( explode( '-', $this->request->getParam( 'scope' ) ), 2, null );
        return $this->dbConfig->getFromDb( $scope, $scopeId );
    }

    /**
     * @return array
     */
    protected function collectSettings()
    {
        $settings = [];
        foreach ( $this->moduleManager->getEnabledModules() as $module ) {
            if ( isset( $module->getData( 'config' )['settings'] ) ) {
                foreach ( $module->getData( 'config' )['settings'] as $groupName => $settingGroup ) {
                    if ( !isset( $settings[$groupName] ) ) {
                        $settings[$groupName] = [
                            'fields' => []
                        ];
                    }
                    if ( isset( $settingGroup['label'] ) ) {
                        $settings[$groupName]['label'] = $settingGroup['label'];
                    }
                    if ( isset( $settingGroup['sort_order'] ) ) {
                        $settings[$groupName]['sort_order'] = $settingGroup['sort_order'];
                    }
                    $settings[$groupName]['fields'] = array_merge( $settings[$groupName]['fields'], $settingGroup['fields'] );
                }
            }
        }
        uksort( $settings, function( $a, $b ) {
            return $a['sort_order'] > $b['sort_order'] ? 1 : ( $a['sort_order'] < $b['sort_order'] ? -1 : 0 );
        } );
        return $settings;
    }

    protected function run()
    {
        $this->registry->register( 'settings', $this->collectSettings() );
        $this->registry->register( 'configurations', $this->getConfigurations() );

        $this->setPageTitle( __( 'Configuration' ) )->render();
    }

}
