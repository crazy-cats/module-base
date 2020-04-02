<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model\Stage;

use CrazyCat\Framework\App\ObjectManager;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@com.com>
 * @link     https://crazy-cat.cn
 */
class Manager {

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    private $objectManager;

    /**
     * @var \CrazyCat\Framework\App\ObjectManager[]
     */
    private $stages;

    /**
     * @var string
     */
    private $currentStageCode;

    public function __construct( ObjectManager$objectManager )
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @return \CrazyCat\Base\Model\Stage[]
     */
    public function getAllStages()
    {
        if ( $this->stages === null ) {
            $stageCollection = $this->objectManager->create( Collection::class )
                    ->addFieldToFilter( 'enabled', [ 'eq' => 1 ] );
            $this->stages = [];
            foreach ( $stageCollection as $stage ) {
                $this->stages[$stage->getData( 'code' )] = $stage;
            }
        }
        return $this->stages;
    }

    /**
     * @param string $code
     * @return \CrazyCat\Base\Model\Stage
     */
    public function getStage( $code )
    {
        $stages = $this->getAllStages();
        if ( !isset( $stages[$code] ) ) {
            throw new \Exception( 'Stage with specified code does not exist.' );
        }
        return $stages[$code];
    }

    /**
     * @return \CrazyCat\Base\Model\Stage
     */
    public function getCurrentStage()
    {
        if ( $this->currentStageCode === null ) {
            foreach ( $this->getAllStages() as $stage ) {
                if ( $stage->getIsDefault() ) {
                    $this->currentStageCode = $stage->getData( 'code' );
                    break;
                }
            }
            if ( $this->currentStageCode === null ) {
                throw new \Exception( 'No default enabled stage specified.' );
            }
        }
        if ( !isset( $this->stages[$this->currentStageCode] ) ) {
            throw new \Exception( 'Stage with specified code does not exist.' );
        }
        return $this->stages[$this->currentStageCode];
    }

    /**
     * @return string
     */
    public function getCurrentStageCode()
    {
        return $this->currentStageCode;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCurrentStageCode( $code )
    {
        $this->getStage( $code );
        $this->currentStageCode = $code;
        return $this;
    }

}
