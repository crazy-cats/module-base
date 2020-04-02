<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Observer;

use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Config;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@com.com>
 * @link     https://crazy-cat.cn
 */
class PrepareTheme {

    /**
     * @var \CrazyCat\Framework\App\Area
     */
    private $area;

    /**
     * @var \CrazyCat\Framework\App\Config
     */
    private $config;

    public function __construct( Area $area, Config $config )
    {
        $this->area = $area;
        $this->config = $config;
    }

    /**
     * @param \CrazyCat\Framework\Data\DataObject $observer
     */
    public function execute( $observer )
    {
        if ( isset( $this->config->getData( $this->area->getCode() )['theme'] ) ) {
            $observer->getThemeManager()->setCurrentTheme( $this->config->getData( $this->area->getCode() )['theme'] );
        }
    }

}
