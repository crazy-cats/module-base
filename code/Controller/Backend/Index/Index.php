<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend\Index;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Index extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function execute()
    {
        $this->setPageTitle(__('Dashboard'))
            ->setMetaKeywords(['CrazyCat', 'CMS', __('dynamic portal')])
            ->setMetaDescription(__('CrazyCat Platform'))
            ->render();
    }
}
