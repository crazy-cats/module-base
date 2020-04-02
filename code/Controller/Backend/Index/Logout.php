<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend\Index;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link https://crazy-cat.cn
 */
class Logout extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        $this->eventManager->dispatch( 'process_backend_logout' );
        $this->messenger->addSuccess( __( 'Logged out successfully.' ) );
        $this->redirect( 'system/index/login' );
    }

}
