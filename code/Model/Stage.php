<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@com.com>
 * @link     https://crazy-cat.cn
 */
class Stage extends \CrazyCat\Framework\App\Component\Module\Model\AbstractModel {

    /**
     * @return void
     */
    protected function construct()
    {
        $this->init( 'stage', 'stage' );
    }

    /**
     * @return void
     */
    protected function afterSave()
    {
        parent::afterSave();

        if ( $this->getData( 'is_default' ) ) {
            $this->conn->update( $this->mainTable, [ 'is_default' => 0 ], [ 'id <> ?' => $this->getId() ] );
        }
    }

    /**
     * @return void
     */
    protected function beforeDelete()
    {
        if ( $this->conn->fetchOne( sprintf( 'SELECT COUNT(*) FROM `%s`', $this->conn->getTableName( $this->mainTable ) ) ) == 1 ) {
            throw new \Exception( 'At least one front stage need to exist in the system.' );
        }

        parent::beforeDelete();
    }

    /**
     * @return void
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        if ( $this->conn->fetchOne( sprintf( 'SELECT COUNT(*) FROM `%s`', $this->conn->getTableName( $this->mainTable ) ) ) == 1 ) {
            $this->conn->update( $this->mainTable, [ 'is_default' => 1 ] );
        }
    }

}
