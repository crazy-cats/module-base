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
class Index extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        $this->setPageTitle( __( 'Dashboard' ) )
                ->setMetaKeywords( [ 'CrazyCat', 'CMS', __( 'dynamic portal' ) ] )
                ->setMetaDescription( __( 'CrazyCat Platform' ) )
                ->render();
    }

}
