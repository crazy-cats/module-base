<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Observer;

use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Config;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class PrepareForRender {

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
     * @param \CrazyCat\Framework\Data\Object $observer
     */
    public function execute( $observer )
    {
        $page = $observer->getPage();

        $page->setData( 'meta_keywords', $this->config->getValue( 'website/default_meta_keywords' ) );
        $page->setData( 'meta_description', $this->config->getValue( 'website/default_meta_description' ) );
        $page->setData( 'meta_robots', $this->config->getValue( 'website/default_meta_robots' ) );
        $page->setData( 'page_title', $this->config->getValue( 'website/default_page_title' ) );
    }

}
