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
class LoginPost extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        try {
            $post = $this->request->getPost();
            $this->eventManager->dispatch( 'process_backend_login', [ 'post' => $post ] );
            $this->messenger->addSuccess( __( 'Logged in successfully.' ) );
        }
        catch ( \Exception $e ) {
            $this->messenger->addError( $e->getMessage() );
        }

        $this->redirect( 'system/index/index' );
    }

}
