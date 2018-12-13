<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Index\Setup;

use CrazyCat\Framework\App\Db\MySql;

/**
 * @category CrazyCat
 * @package CrazyCat\AppFront
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Upgrade extends \CrazyCat\Framework\App\Module\Setup\AbstractUpgrade {

    private function createConfigTable()
    {
        $columns = [
                [ 'name' => 'scope', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 8, 'null' => false ],
                [ 'name' => 'scope_id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false ],
                [ 'name' => 'path', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 64, 'null' => false ],
                [ 'name' => 'value', 'type' => MySql::COL_TYPE_TEXT, 'null' => false ]
        ];
        $indexes = [
                [ 'columns' => [ 'scope', 'scope_id' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'scope', 'scope_id', 'path' ], 'type' => MySql::INDEX_UNIQUE ]
        ];
        $this->conn->createTable( 'config', $columns, $indexes );
    }

    /**
     * @param string|null $currentVersion
     */
    public function execute( $currentVersion )
    {
        if ( $currentVersion === null ) {
            $this->createConfigTable();
        }
    }

}
