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
class Login extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function execute()
    {
        if ($this->session->isLoggedIn()) {
            $this->redirect('system/index');
        } else {
            $this->setPageTitle(__('Administrator Login'))
                ->setMetaKeywords(['CrazyCat', 'CMS', __('dynamic portal')])
                ->setMetaDescription('CrazyCat')
                ->render();
        }
    }
}
