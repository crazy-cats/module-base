<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Model\Source;

use CrazyCat\Framework\App\Translator;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Languages extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    public function __construct( Translator $translator )
    {
        foreach ( $translator->getLanguages() as $language ) {
            $this->sourceData[$language['name']] = $language['code'];
        }
    }

}
