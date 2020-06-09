<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Form\Renderer;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
abstract class AbstractRenderer extends \CrazyCat\Base\Block\Template
{
    /**
     * @var string|null
     */
    protected $fieldNamePrefix = null;

    /**
     * @var bool
     */
    protected $isMultiple = false;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var bool
     */
    protected $withLabel = false;

    /**
     * @var bool
     */
    protected $withWrapper = false;

    /**
     * @param string|null $prefix
     * @return $this
     */
    public function setFieldNamePrefix($prefix)
    {
        $this->fieldNamePrefix = $prefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        if ($this->fieldNamePrefix !== null) {
            return sprintf(
                '%s[%s]%s',
                $this->fieldNamePrefix,
                $this->getField()['name'],
                ($this->isMultiple ? '[]' : '')
            );
        } else {
            return $this->getField()['name'] . ($this->isMultiple ? '[]' : '');
        }
    }

    /**
     * @return string
     */
    public function getFieldId()
    {
        $fieldName = preg_replace('/\W/', '_', $this->getField()['name']);
        if ($this->fieldNamePrefix !== null) {
            return sprintf('%s_%s', $this->fieldNamePrefix, $fieldName);
        } else {
            return $fieldName;
        }
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param bool|null $isMultiple
     * @return bool|$this
     */
    public function isMultiple($isMultiple = null)
    {
        if ($isMultiple === null) {
            return $this->isMultiple;
        }

        $this->isMultiple = $isMultiple;
        return $this;
    }

    /**
     * @param bool|null $withLabel
     * @return bool|$this
     */
    public function withLabel($withLabel = null)
    {
        if ($withLabel === null) {
            return $this->withLabel;
        }

        $this->withLabel = $withLabel;
        return $this;
    }

    /**
     * @param bool|null $withWrapper
     * @return bool|$this
     */
    public function withWrapper($withWrapper = null)
    {
        if ($withWrapper === null) {
            return $this->withWrapper;
        }

        $this->withWrapper = $withWrapper;
        return $this;
    }
}
