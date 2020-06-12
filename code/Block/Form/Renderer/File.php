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
class File extends AbstractRenderer
{
    protected $template = 'CrazyCat\Base::form/file';

    public function getFileUrl()
    {
        return $this->getBaseUrl() . 'media/' . $this->getField()['media_folder'] . '/' . $this->getValue();
    }
}
