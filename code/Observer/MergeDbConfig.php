<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Index\Observer;

use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Config;
use CrazyCat\Framework\App\Db\Manager as DbManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Index
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class MergeDbConfig {

    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    /**
     * @var \CrazyCat\Framework\App\Db\AbstractAdapter
     */
    private $conn;

    public function __construct( DbManager $dbManager, Config $config )
    {
        $this->config = $config;
        $this->conn = $dbManager->getConnection();
    }

    /**
     * @return void
     */
    public function execute()
    {
        $sql = sprintf( 'SELECT `path`, `value` FROM `%s` WHERE `scope` = ?', $this->conn->getTableName( 'config' ) );
        $config = $this->conn->fetchPairs( $sql, [ Area::CODE_GLOBAL ] );
        $this->config->addData( [ Area::CODE_GLOBAL => $config ] );
    }

}
