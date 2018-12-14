<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Controller\Backend\Index;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Login extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        if ( $this->session->isLoggedIn() ) {
            $this->redirect( 'system/index' );
        }
        else {
            $this->setPageTitle( __( 'Administrator Login' ) )
                    ->setMetaKeywords( [ 'CrazyCat', 'CMS', __( 'dynamic portal' ) ] )
                    ->setMetaDescription( 'CrazyCat' )
                    ->render();
        }
    }

}
