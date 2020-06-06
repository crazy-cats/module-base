<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Observer;

use CrazyCat\Base\Model\Stage\Manager as StageManager;
use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Io\Http\Cookies;
use CrazyCat\Framework\App\Io\Http\Request as HttpRequest;
use CrazyCat\Framework\App\Timezone;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class PrepareForArea
{
    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    /**
     * @var \CrazyCat\Base\Model\Config
     */
    private $dbConfig;

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    private $objectManager;

    public function __construct(
        \CrazyCat\Framework\App\Config $config,
        \CrazyCat\Framework\App\ObjectManager $objectManager
    ) {
        $this->config = $config;
        $this->objectManager = $objectManager;
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function execute($observer)
    {
        $areaCode = $observer->getArea()->getCode();

        if ($areaCode == Area::CODE_FRONTEND || $areaCode == Area::CODE_BACKEND) {
            if ($areaCode == Area::CODE_FRONTEND) {
                /* @var $cookies \CrazyCat\Framework\App\Io\Http\Cookies */
                $cookies = $this->objectManager->get(Cookies::class);

                /* @var $request \CrazyCat\Framework\App\Io\Http\Request */
                $request = $this->objectManager->get(HttpRequest::class);

                /* @var $stageManager \CrazyCat\Base\Model\Stage\Manager */
                $stageManager = $this->objectManager->get(StageManager::class);

                /**
                 * Initialize stage
                 */
                if (($stageCode = $request->getParam('stage', $cookies->getData('stage')))) {
                    $stageManager->setCurrentStageCode($stageCode);
                }
            }

            /* @var $timezone \CrazyCat\Framework\App\Timezone */
            $timezone = $this->objectManager->get(Timezone::class);

            /**
             * Initialize timezone
             */
            $timezone->setTimezone(new \DateTimeZone($this->config->getValue('general/timezone') ?: 'UTC'));
        }
    }
}
