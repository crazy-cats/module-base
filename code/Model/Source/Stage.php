<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Model\Source;

use CrazyCat\Core\Model\Stage\Collection as StageCollection;
use CrazyCat\Framework\App\ObjectManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Stage extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    public function __construct( ObjectManager $objectManager )
    {
        foreach ( $objectManager->create( StageCollection::class ) as $frontStage ) {
            $this->sourceData[$frontStage->getData( 'name' )] = $frontStage->getId();
        }
    }

}
