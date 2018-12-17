<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Block\Form\Renderer;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Select extends abstractRenderer {

    protected $template = 'CrazyCat\Core::form/select';

    /**
     * @var boolean
     */
    protected $isMultiple = false;

    /**
     * @param boolean|null $isMultiple
     * @return boolean|$this
     */
    public function isMultiple( $isMultiple = null )
    {
        if ( $isMultiple === null ) {
            return $this->isMultiple;
        }

        $this->isMultiple = $isMultiple;
        return $this;
    }

}
