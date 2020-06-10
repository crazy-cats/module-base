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
class LoginPost extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @return void
     */
    protected function execute()
    {
        try {
            $post = $this->request->getPost();
            $this->eventManager->dispatch('process_backend_login', ['post' => $post]);
            $this->messenger->addSuccess(__('Logged in successfully.'));
        } catch (\Exception $e) {
            $this->messenger->addError($e->getMessage());
        }

        $this->redirect('system/index/index');
    }
}
