<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Backend;

/**
 * @category CrazyCat
 * @package  CrazyCat\Framework
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Context extends \CrazyCat\Framework\App\Component\Theme\Block\Context
{
    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    public function __construct(
        \CrazyCat\Framework\App\ObjectManager $objectManager,
        \CrazyCat\Framework\App\Area $area,
        \CrazyCat\Framework\App\Io\Http\Request $request,
        \CrazyCat\Framework\App\Registry $registry,
        \CrazyCat\Framework\App\Cache\Manager $cacheManager,
        \CrazyCat\Framework\App\Component\Module\Manager $moduleManager,
        \CrazyCat\Framework\App\Component\Language\Translator $translator,
        \CrazyCat\Framework\App\Component\Theme\Manager $themeManager,
        \CrazyCat\Framework\App\Io\Http\Url $url,
        \CrazyCat\Framework\App\EventManager $eventManager
    ) {
        parent::__construct(
            $area,
            $cacheManager,
            $translator,
            $themeManager,
            $eventManager,
            $request,
            $moduleManager,
            $registry,
            $url
        );

        $this->objectManager = $objectManager;
    }

    /**
     * @return \CrazyCat\Framework\App\ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }
}
