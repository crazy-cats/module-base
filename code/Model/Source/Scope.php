<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model\Source;

use CrazyCat\Base\Model\Stage\Collection as StageCollection;
use CrazyCat\Framework\App\Area;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Scope extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    public function __construct(
        \CrazyCat\Framework\App\ObjectManager $objectManager
    ) {
        $frontendOptions = [];
        foreach ($objectManager->create(StageCollection::class) as $frontStage) {
            $frontendOptions[$frontStage->getData('name')] = Area::CODE_FRONTEND . '-' . $frontStage->getId();
        }
        $this->sourceData = [
            __('Global')   => Area::CODE_GLOBAL,
            __('Frontend') => $frontendOptions
        ];
    }
}
