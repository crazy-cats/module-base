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
abstract class abstractRenderer extends \CrazyCat\Core\Block\Template {

    /**
     * @var string|null
     */
    protected $fieldNamePrefix = null;

    /**
     * @var boolean
     */
    protected $withLabel = false;

    /**
     * @var boolean
     */
    protected $withWrapper = false;

    /**
     * @param string|null $prefix
     * @return $this
     */
    public function setFieldNamePrefix( $prefix )
    {
        $this->fieldNamePrefix = $prefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        if ( $this->fieldNamePrefix !== null ) {
            return sprintf( '%s[%s]', $this->fieldNamePrefix, $this->getField()['name'] );
        }
        else {
            return $this->getField()['name'];
        }
    }

    /**
     * @return string
     */
    public function getFieldId()
    {
        if ( $this->fieldNamePrefix !== null ) {
            return sprintf( '%s_%s', $this->fieldNamePrefix, $this->getField()['name'] );
        }
        else {
            return $this->getField()['name'];
        }
    }

    /**
     * @param boolean|null $withLabel
     * @return boolean|$this
     */
    public function withLabel( $withLabel = null )
    {
        if ( $withLabel === null ) {
            return $this->withLabel;
        }

        $this->withLabel = $withLabel;
        return $this;
    }

    /**
     * @param boolean|null $withWrapper
     * @return boolean|$this
     */
    public function withWrapper( $withWrapper = null )
    {
        if ( $withWrapper === null ) {
            return $this->withWrapper;
        }

        $this->withWrapper = $withWrapper;
        return $this;
    }

}
