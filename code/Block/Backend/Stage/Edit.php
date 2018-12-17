<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Block\Backend\Stage;

use CrazyCat\Core\Model\Source\YesNo as SourceYesNo;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Edit extends \CrazyCat\Core\Block\Backend\AbstractEdit {

    /**
     * @return array
     */
    public function getFields()
    {
        return [
            'general' => [
                'label' => __( 'General' ),
                'fields' => [
                        [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                        [ 'name' => 'name', 'label' => __( 'Stage Name' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                        [ 'name' => 'code', 'label' => __( 'Code' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                        [ 'name' => 'enabled', 'label' => __( 'Enabled' ), 'type' => 'select', 'source' => SourceYesNo::class ],
                        [ 'name' => 'is_default', 'label' => __( 'Is Default' ), 'type' => 'select', 'source' => SourceYesNo::class ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return getUrl( 'system/stage/save' );
    }

}
