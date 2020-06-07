<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model\Source;

use CrazyCat\Base\Model\Stage\Collection as StageCollection;
use CrazyCat\Framework\App\ObjectManager;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Stage extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    public function __construct(ObjectManager $objectManager)
    {
        foreach ($objectManager->create(StageCollection::class) as $frontStage) {
            $label = sprintf('%s ( ID: %d )', $frontStage->getData('name'), $frontStage->getId());
            $this->sourceData[$label] = $frontStage->getId();
        }
    }
}
