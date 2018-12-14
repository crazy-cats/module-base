<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Block\Backend\Stage;

use CrazyCat\Core\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Edit extends \CrazyCat\Framework\App\Module\Block\Backend\AbstractEdit {

    /**
     * @var \CrazyCat\Core\Model\Source\YesNo
     */
    protected $sourceYesNo;

    public function __construct( SourceYesNo $sourceYesNo, Context $context, $data )
    {
        parent::__construct( $context, $data );

        $this->sourceYesNo = $sourceYesNo;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                [ 'name' => 'name', 'label' => __( 'Stage Name' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                [ 'name' => 'code', 'label' => __( 'Code' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                [ 'name' => 'enabled', 'label' => __( 'Enabled' ), 'type' => 'select', 'options' => $this->sourceYesNo->toOptionsArray() ],
                [ 'name' => 'is_default', 'label' => __( 'Is Default' ), 'type' => 'select', 'options' => $this->sourceYesNo->toOptionsArray() ]
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
