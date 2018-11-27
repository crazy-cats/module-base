<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Index\Block;

use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\EventManager;
use CrazyCat\Framework\App\Module\Manager as ModuleManager;
use CrazyCat\Framework\App\Theme\Manager as ThemeManager;
use CrazyCat\Framework\App\Session\Messenger;

/**
 * @category CrazyCat
 * @package CrazyCat\Index
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Message extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Index::message';

    /**
     * @var \CrazyCat\Framework\App\Session\Messenger
     */
    protected $messenger;

    public function __construct( Messenger $messenger, Area $area, ModuleManager $moduleManager, ThemeManager $themeManager, EventManager $eventManager, array $data = [] )
    {
        parent::__construct( $area, $moduleManager, $themeManager, $eventManager, $data );

        $this->messenger = $messenger;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messenger->getMessages( true );
    }

}
