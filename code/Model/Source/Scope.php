<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Model\Source;

use CrazyCat\Core\Model\Stage\Collection as StageCollection;
use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\ObjectManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Scope extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    public function __construct( ObjectManager $objectManager )
    {
        $frontendOptions = [];
        foreach ( $objectManager->create( StageCollection::class ) as $frontStage ) {
            $frontendOptions[$frontStage->getData( 'name' )] = Area::CODE_FRONTEND . '-' . $frontStage->getId();
        }
        $this->sourceData = [
            __( 'Global' ) => Area::CODE_GLOBAL,
            __( 'Frontend' ) => $frontendOptions
        ];
    }

}
