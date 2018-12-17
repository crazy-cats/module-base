<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Controller\Backend\Stage;

use CrazyCat\Core\Block\Backend\Stage\Grid as GridBlock;
use CrazyCat\Core\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Core\Model\Stage\Collection;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Grid extends \CrazyCat\Core\Controller\Backend\AbstractGridAction {

    protected function construct()
    {
        $this->init( Collection::class, GridBlock::class );
    }

    /**
     * @param array $collectionData
     * @return array
     */
    protected function processData( $collectionData )
    {
        $sourceYesNo = $this->objectManager->get( SourceYesNo::class );
        foreach ( $collectionData['items'] as &$item ) {
            $item['enabled'] = $sourceYesNo->getLabel( $item['enabled'] );
            $item['is_default'] = $sourceYesNo->getLabel( $item['is_default'] );
        }
        return $collectionData;
    }

}
