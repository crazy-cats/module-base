<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model;

use CrazyCat\Base\Framework\Config;
use CrazyCat\Framework\App\Area;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
abstract class AbstractLangCollection extends \CrazyCat\Framework\App\Component\Module\Model\AbstractLangCollection
{
    /**
     * @return string
     * @throws \ReflectionException
     */
    protected function getDefaultLang()
    {
        /* @var $area \CrazyCat\Framework\App\Area */
        $area = $this->objectManager->get(\CrazyCat\Framework\App\Area::class);

        /* @var $scopeConfig \CrazyCat\Base\Framework\Config */
        $scopeConfig = $this->objectManager->get(\CrazyCat\Base\Framework\Config::class);

        if ($area->getCode() == Area::CODE_FRONTEND) {
            /* @var $stageManager \CrazyCat\Base\Model\Stage\Manager */
            $stageManager = $this->objectManager->get(\CrazyCat\Base\Model\Stage\Manager::class);
            return $scopeConfig->getValue(
                'general/default_language',
                Config::SCOPE_STAGE,
                $stageManager->getCurrentStage()->getId()
            );
        } else {
            return $scopeConfig->getValue(
                'general/default_language',
                Config::SCOPE_GLOBAL
            );
        }
    }
}
