<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Block\Backend;

use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Config extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Core::config';

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $configurations;

    public function __construct( ObjectManager $objectManager, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->objectManager = $objectManager;
    }

    /**
     * @return array
     */
    public function getOptions( $field )
    {
        if ( isset( $field['options'] ) ) {
            return $field['options'];
        }
        else {
            return $this->objectManager->get( $field['source'] )->toOptionArray();
        }
    }

    /**
     * @return mixed
     */
    public function getConfig( $path )
    {
        if ( $this->configurations === null ) {
            $this->configurations = $this->registry->registry( 'configurations' );
        }
        return isset( $this->configurations[$path] ) ? $this->configurations[$path] : null;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->registry->registry( 'settings' );
    }

}
