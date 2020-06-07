<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Stage extends \CrazyCat\Framework\App\Component\Module\Model\AbstractModel
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function construct()
    {
        $this->init('stage', 'stage');
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function afterSave()
    {
        parent::afterSave();

        if ($this->getData('is_default')) {
            $this->conn->update($this->mainTable, ['is_default' => 0], ['id <> ?' => $this->getId()]);
        }
    }

    /**
     * @return void
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function beforeDelete()
    {
        $numStage = $this->conn->fetchOne(
            sprintf('SELECT COUNT(*) FROM `%s`', $this->conn->getTableName($this->mainTable))
        );
        if ($numStage == 1) {
            throw new \Exception('At least one front stage need to exist in the system.');
        }

        parent::beforeDelete();
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        $numStage = $this->conn->fetchOne(
            sprintf('SELECT COUNT(*) FROM `%s`', $this->conn->getTableName($this->mainTable))
        );
        if ($numStage == 1) {
            $this->conn->update($this->mainTable, ['is_default' => 1]);
        }
    }

}
