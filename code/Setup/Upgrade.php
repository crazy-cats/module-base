<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Setup;

use CrazyCat\Framework\App\Db\MySql;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Upgrade extends \CrazyCat\Framework\App\Module\Setup\AbstractUpgrade {

    private function createConfigTable()
    {
        $columns = [
                [ 'name' => 'scope', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 8, 'null' => false ],
                [ 'name' => 'scope_id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'path', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 64, 'null' => false ],
                [ 'name' => 'value', 'type' => MySql::COL_TYPE_TEXT, 'null' => false ]
        ];
        $indexes = [
                [ 'columns' => [ 'scope', 'scope_id' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'scope', 'scope_id', 'path' ], 'type' => MySql::INDEX_UNIQUE ]
        ];
        $this->conn->createTable( 'config', $columns, $indexes );
    }

    private function createStageTable()
    {
        $columns = [
                [ 'name' => 'id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'auto_increment' => true ],
                [ 'name' => 'name', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 256, 'null' => false ],
                [ 'name' => 'code', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false ],
                [ 'name' => 'enabled', 'type' => MySql::COL_TYPE_TINYINT, 'length' => 1, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'is_default', 'type' => MySql::COL_TYPE_TINYINT, 'length' => 1, 'unsign' => true, 'null' => false, 'default' => 0 ]
        ];
        $indexes = [
                [ 'columns' => [ 'code' ], 'type' => MySql::INDEX_UNIQUE ],
                [ 'columns' => [ 'enabled' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'is_default' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'name' ], 'type' => MySql::INDEX_FULLTEXT ]
        ];
        $this->conn->createTable( 'stage', $columns, $indexes );
    }

    private function createDefaultStage()
    {
        $this->conn->insert( 'stage', [
            'name' => 'Default',
            'code' => 'default',
            'enabled' => 1,
            'is_default' => 1 ] );
    }

    /**
     * @param string|null $currentVersion
     */
    public function execute( $currentVersion )
    {
        if ( $currentVersion === null ) {
            $this->createConfigTable();
            $this->createStageTable();
            $this->createDefaultStage();
        }
    }

}
