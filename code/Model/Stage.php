<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Model;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Stage extends \CrazyCat\Framework\App\Module\Model\AbstractModel {

    /**
     * @return void
     */
    protected function construct()
    {
        $this->init( 'stage', 'stage' );
    }

    protected function beforeDelete()
    {
        if ( $this->conn->fetchOne( sprintf( 'SELECT COUNT(*) FROM `%s`', $this->conn->getTableName( $this->mainTable ) ) ) == 1 ) {
            throw new \Exception( 'At least one front stage need to exist in the system.' );
        }

        parent::beforeDelete();
    }

}
