<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Head extends Template
{
    protected $template = 'CrazyCat\Base::head';

    /**
     * @return string
     */
    public function getLangCode()
    {
        return $this->translator->getLangCode();
    }

    /**
     * @return string
     */
    public function getLocalStoragePrefix()
    {
        return md5($this->getUrl('')) . ' :: ';
    }
}
