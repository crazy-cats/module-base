<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Backend\Stage;

use CrazyCat\Base\Block\Backend\Context;
use CrazyCat\Base\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Framework\App\Io\Http\Session\Backend as Session;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Grid extends \CrazyCat\Base\Block\Backend\AbstractGrid
{
    const BOOKMARK_KEY = 'stage';

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getFields()
    {
        return [
            [
                'name'   => 'id',
                'label'  => __('ID'),
                'sort'   => true,
                'width'  => 100,
                'filter' => ['type' => 'text', 'condition' => 'eq']
            ],
            [
                'name'   => 'name',
                'label'  => __('Stage Name'),
                'sort'   => true,
                'filter' => ['type' => 'text', 'condition' => 'like']
            ],
            [
                'name'   => 'code',
                'label'  => __('Code'),
                'sort'   => true,
                'filter' => ['type' => 'text', 'condition' => 'like']
            ],
            [
                'name'   => 'enabled',
                'label'  => __('Enabled'),
                'sort'   => true,
                'width'  => 130,
                'filter' => ['type' => 'select', 'source' => SourceYesNo::class, 'condition' => 'eq']
            ],
            [
                'name'   => 'is_default',
                'label'  => __('Is Default'),
                'sort'   => true,
                'width'  => 130,
                'filter' => ['type' => 'select', 'source' => SourceYesNo::class, 'condition' => 'eq']
            ],
            [
                'label'   => __('Actions'),
                'actions' => [
                    ['name' => 'edit', 'label' => __('Edit'), 'url' => $this->getUrl('system/stage/edit')],
                    [
                        'name'    => 'delete',
                        'label'   => __('Delete'),
                        'confirm' => __('Sure you want to remove this item?'),
                        'url'     => $this->getUrl('system/stage/delete')
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->getUrl('system/stage/grid');
    }
}
