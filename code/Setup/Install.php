<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Setup;

use CrazyCat\Framework\App\Db\MySql;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Install extends \CrazyCat\Framework\App\Component\Module\Setup\AbstractSetup
{
    private function createConfigTable()
    {
        $columns = [
            ['name' => 'scope', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 8, 'null' => false],
            ['name' => 'stage_id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'default' => 0],
            ['name' => 'path', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 64, 'null' => false],
            ['name' => 'value', 'type' => MySql::COL_TYPE_TEXT, 'null' => false]
        ];
        $indexes = [
            ['columns' => ['scope', 'stage_id'], 'type' => MySql::INDEX_NORMAL],
            ['columns' => ['scope', 'stage_id', 'path'], 'type' => MySql::INDEX_UNIQUE]
        ];
        $this->conn->createTable('config', $columns, $indexes);
    }

    private function createStageTable()
    {
        $columns = [
            [
                'name'           => 'id',
                'type'           => MySql::COL_TYPE_INT,
                'unsign'         => true,
                'null'           => false,
                'auto_increment' => true
            ],
            ['name' => 'name', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 256, 'null' => false],
            ['name' => 'code', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false],
            [
                'name'    => 'enabled',
                'type'    => MySql::COL_TYPE_TINYINT,
                'length'  => 1,
                'unsign'  => true,
                'null'    => false,
                'default' => 0
            ],
            [
                'name'    => 'is_default',
                'type'    => MySql::COL_TYPE_TINYINT,
                'length'  => 1,
                'unsign'  => true,
                'null'    => false,
                'default' => 0
            ]
        ];
        $indexes = [
            ['columns' => ['code'], 'type' => MySql::INDEX_UNIQUE],
            ['columns' => ['enabled'], 'type' => MySql::INDEX_NORMAL],
            ['columns' => ['is_default'], 'type' => MySql::INDEX_NORMAL],
            ['columns' => ['name'], 'type' => MySql::INDEX_FULLTEXT]
        ];
        $this->conn->createTable('stage', $columns, $indexes);
    }

    private function createDefaultStage()
    {
        $this->conn->insert(
            'stage',
            [
                'name'       => 'Default',
                'code'       => 'default',
                'enabled'    => 1,
                'is_default' => 1
            ]
        );
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->createConfigTable();
        $this->createStageTable();
        $this->createDefaultStage();
    }
}
