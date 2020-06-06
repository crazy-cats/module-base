<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend\Stage;

use CrazyCat\Base\Block\Backend\Stage\Grid as GridBlock;
use CrazyCat\Base\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Base\Model\Stage\Collection;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Grid extends \CrazyCat\Base\Controller\Backend\AbstractGridAction
{
    protected function construct()
    {
        $this->init(Collection::class, GridBlock::class);
    }

    /**
     * @param array $collectionData
     * @return array
     * @throws \ReflectionException
     */
    protected function processData($collectionData)
    {
        $sourceYesNo = $this->objectManager->get(SourceYesNo::class);
        foreach ($collectionData['items'] as &$item) {
            $item['enabled'] = $sourceYesNo->getLabel($item['enabled']);
            $item['is_default'] = $sourceYesNo->getLabel($item['is_default']);
        }
        return $collectionData;
    }
}
