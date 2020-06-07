<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Backend\Stage;

use CrazyCat\Base\Model\Source\YesNo as SourceYesNo;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Edit extends \CrazyCat\Base\Block\Backend\AbstractEdit
{
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getFields()
    {
        return [
            'general' => [
                'label'  => __('General'),
                'fields' => [
                    [
                        'name'  => 'id',
                        'label' => __('ID'),
                        'type'  => 'hidden'
                    ],
                    [
                        'name'       => 'name',
                        'label'      => __('Stage Name'),
                        'type'       => 'text',
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'       => 'code',
                        'label'      => __('Code'),
                        'type'       => 'text',
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'   => 'enabled',
                        'label'  => __('Enabled'),
                        'type'   => 'select',
                        'source' => SourceYesNo::class
                    ],
                    [
                        'name'   => 'is_default',
                        'label'  => __('Is Default'),
                        'type'   => 'select',
                        'source' => SourceYesNo::class
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('system/stage/save');
    }
}
