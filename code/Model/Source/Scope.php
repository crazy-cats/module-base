<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model\Source;

use CrazyCat\Base\Framework\Config;
use CrazyCat\Base\Model\Stage\Collection as StageCollection;

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
            $frontendOptions[$frontStage->getData('name')] = Config::SCOPE_STAGE . '-' . $frontStage->getId();
        }
        $this->sourceData = [
            __('Global')   => Config::SCOPE_GLOBAL,
            __('Frontend') => $frontendOptions
        ];
    }
}
