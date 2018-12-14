<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Model\Source;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class YesNo {

    /**
     * @param boolean $withEmpty
     * @return array
     */
    public function toOptionsArray( $withEmpty = false )
    {
        $options = [
                [ 'value' => '1', 'label' => __( 'Yes' ) ],
                [ 'value' => '0', 'label' => __( 'No' ) ]
        ];

        if ( $withEmpty ) {
            array_unshift( $options, [ 'value' => '', 'label' => '' ] );
        }

        return $options;
    }

}
