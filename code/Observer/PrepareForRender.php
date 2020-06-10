<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Observer;

use CrazyCat\Base\Framework\Config;
use CrazyCat\Base\Model\Stage\Manager as StageManager;
use CrazyCat\Framework\App\Area;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class PrepareForRender
{
    /**
     * @var \CrazyCat\Framework\App\Area
     */
    private $area;

    /**
     * @var \CrazyCat\Base\Framework\Config
     */
    private $config;

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    private $objectManager;

    public function __construct(
        \CrazyCat\Base\Framework\Config $config,
        \CrazyCat\Framework\App\Area $area,
        \CrazyCat\Framework\App\ObjectManager $objectManager
    ) {
        $this->area = $area;
        $this->config = $config;
        $this->objectManager = $objectManager;
    }

    /**
     * @param \CrazyCat\Framework\Data\DataObject $observer
     * @throws \Exception
     */
    public function execute($observer)
    {
        /* @var $page \CrazyCat\Framework\App\Component\Theme\Page */
        $page = $observer->getPage();

        if ($this->area->getCode() == Area::CODE_BACKEND) {
            $scope = Config::SCOPE_GLOBAL;
            $stageId = StageManager::GLOBAL_STAGE_ID;
        } else {
            $scope = Config::SCOPE_STAGE;
            $stageId = $this->objectManager->get(StageManager::class)->getCurrentStage()->getId();
        }

        $page->setData(
            'meta_keywords',
            $this->config->getValue('website/default_meta_keywords', $scope, $stageId)
        );
        $page->setData(
            'meta_description',
            $this->config->getValue('website/default_meta_description', $scope, $stageId)
        );
        $page->setData(
            'meta_robots',
            $this->config->getValue('website/default_meta_robots', $scope, $stageId)
        );
        $page->setData(
            'page_title',
            $this->config->getValue('website/default_page_title', $scope, $stageId)
        );
    }
}
