<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Observer;

use CrazyCat\Base\Model\Stage;
use CrazyCat\Framework\App\Area;
use CrazyCat\Base\Framework\Config;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class PrepareTheme
{
    /**
     * @var \CrazyCat\Framework\App\Area
     */
    private $area;

    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    /**
     * @var \CrazyCat\Base\Framework\Config
     */
    private $scopeConfig;

    /**
     * @var \CrazyCat\Base\Model\Stage\Manager
     */
    private $stageManager;

    public function __construct(
        \CrazyCat\Base\Framework\Config $scopeConfig,
        \CrazyCat\Base\Model\Stage\Manager $stageManager,
        \CrazyCat\Framework\App\Area $area,
        \CrazyCat\Framework\App\Config $config
    ) {
        $this->area = $area;
        $this->config = $config;
        $this->scopeConfig = $scopeConfig;
        $this->stageManager = $stageManager;
    }

    /**
     * @param \CrazyCat\Framework\Data\DataObject $observer
     * @throws \Exception
     */
    public function execute($observer)
    {
        /* @var $themeManager \CrazyCat\Framework\App\Component\Theme\Manager */
        $themeManager = $observer->getThemeManager();
        if ($this->area->getCode() == Area::CODE_FRONTEND) {
            $currentStageId = $this->stageManager->getCurrentStage()->getId();
            $theme = $this->scopeConfig->getValue('website/theme', Config::SCOPE_STAGE, $currentStageId);
            $themeManager->setCurrentTheme($theme);
        } elseif ($this->area->getCode() == Area::CODE_BACKEND) {
            $backendConfig = $this->config->getValue(Area::CODE_BACKEND);
            $themeManager->setCurrentTheme($backendConfig['theme']);
        }
    }
}
