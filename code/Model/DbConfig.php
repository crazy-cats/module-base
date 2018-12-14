<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Model;

use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Db\Manager as DbManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class DbConfig {

    /**
     * @var \CrazyCat\Framework\App\Db\AbstractAdapter
     */
    private $conn;

    /**
     * @var array
     */
    private $configurations = [];

    public function __construct( DbManager $dbManager )
    {
        $this->conn = $dbManager->getConnection();
    }

    /**
     * @param string $scope
     * @param int|null $scopeId
     * @return array
     */
    public function getFromDb( $scope, $scopeId = null )
    {
        $sql = sprintf( 'SELECT `path`, `value` FROM `%s` WHERE `scope` = ? AND `scope_id` = ?', $this->conn->getTableName( 'config' ) );
        return $this->conn->fetchPairs( $sql, [ $scope, $scopeId ] );
    }

    /**
     * @param string $path
     * @param string $scope
     * @param int|null $scopeId
     * @return mixed
     */
    public function getValue( $path, $scope = Area::CODE_GLOBAL, $scopeId = null )
    {
        if ( !isset( $this->configurations[Area::CODE_GLOBAL] ) ) {
            $this->configurations[Area::CODE_GLOBAL] = $this->getFromDb( Area::CODE_GLOBAL );
        }
        if ( $scope == Area::CODE_GLOBAL ) {
            $key = $scope;
        }
        else {
            if ( $scopeId === null ) {
                throw new \Exception( __( 'Scope ID is required.' ) );
            }
            $key = $scope . '-' . $scopeId;
            if ( !isset( $this->configurations[$key] ) ) {
                $this->configurations[$key] = array_merge( $this->configurations[Area::CODE_GLOBAL], $this->getFromDb( $scope, $scopeId ) );
            }
        }
        return isset( $this->configurations[$key][$path] ) ? json_decode( $this->configurations[$key][$path], true ) : null;
    }

}
