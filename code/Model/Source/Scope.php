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
class Scope {

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    private $objectManager;

    /**
     * @var array
     */
    private $options;

    public function __construct( ObjectManager $objectManager )
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @return array
     */
    public function toOptionsArray()
    {
        if ( $this->options === null ) {
            $frontendOptions = [];
            foreach ( $this->objectManager->create( StageCollection::class ) as $frontStage ) {
                $frontendOptions[] = [ 'label' => $frontStage->getData( 'name' ), 'value' => Area::CODE_FRONTEND . '-' . $frontStage->getId() ];
            }
            $this->options = [
                    [ 'label' => __( 'Global' ), 'value' => Area::CODE_GLOBAL ],
                //[ 'label' => __( 'CLI' ), 'value' => Area::CODE_CLI ],
                //[ 'label' => __( 'CRON' ), 'value' => Area::CODE_CRON ],
                //[ 'label' => __( 'API' ), 'value' => Area::CODE_API ],
                //[ 'label' => __( 'Backend' ), 'value' => Area::CODE_BACKEND ],
                [ 'label' => __( 'Frontend' ), 'value' => $frontendOptions ]
            ];
        }
        return $this->options;
    }

}
