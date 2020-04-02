<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend\Translate;

use CrazyCat\Framework\App\Io\Http\Response;

/**
 * @category CrazyCat
 * @package CrazyCat\Admin
 * @author Bruce Z <152416319@qq.com>
 * @link https://crazy-cat.cn
 */
class Source extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        $translations = $this->translator->getTranslations( $this->translator->getLangCode() );
        $this->response->setType( Response::TYPE_JSON )->setData( $translations );
    }

}
