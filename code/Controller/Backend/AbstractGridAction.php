<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend;

use CrazyCat\Base\Block\Backend\AbstractGrid;
use CrazyCat\Framework\App\Io\Http\Response;
use CrazyCat\Framework\Utility\StaticVariable;

/**
 * @category CrazyCat
 * @package  CrazyCat\Framework
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
abstract class AbstractGridAction extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    const DEFAULT_PAGE_SIZE = 20;

    /**
     * @var \CrazyCat\Base\Block\Backend\AbstractGrid
     */
    protected $block;

    /**
     * @var \CrazyCat\Framework\App\Component\Module\Model\AbstractCollection
     */
    protected $collection;

    public function __construct(
        \CrazyCat\Framework\App\Component\Module\Controller\Backend\Context $context,
        \CrazyCat\Framework\App\Io\Http\Request $request
    ) {
        parent::__construct($context, $request);

        $this->construct();
    }

    /**
     * @param string $collectionClass
     * @throws \ReflectionException
     */
    protected function init($collectionClass, $blockClass)
    {
        $this->block = $this->objectManager->create($blockClass);
        $this->collection = $this->objectManager->create($collectionClass);
    }

    /**
     * @param array|null $filters
     * @return array
     */
    protected function processFilters($filters)
    {
        if (empty($filters)) {
            return [];
        }

        foreach ($this->block->getFields() as $field) {
            if (empty($field['filter']['type'])) {
                continue;
            }
            switch ($field['filter']['type']) {
                case AbstractGrid::FIELD_TYPE_SELECT:
                    if ($filters[$field['name']] != StaticVariable::NO_SELECTION) {
                        $this->collection->addFieldToFilter(
                            $field['name'],
                            [$field['filter']['condition'] => $filters[$field['name']]]
                        );
                    }
                    break;

                case AbstractGrid::FIELD_TYPE_TEXT:
                    if (!empty($filter = trim($filters[$field['name']]))) {
                        $this->collection->addFieldToFilter(
                            $field['name'],
                            [$field['filter']['condition'] => ($field['filter']['condition'] == 'like') ? ('%' . $filter . '%') : $filter]
                        );
                    }
                    break;
            }
        }

        return $filters;
    }

    /**
     * @param string|null $sorting
     * @return array
     */
    protected function processSorting($sorting)
    {
        $sortings = $this->block->getSortings();
        if (!empty($sorting)) {
            list($fieldName, $dir) = explode(',', $sorting);
            foreach ($sortings as $k => $sorting) {
                if ($sorting['field'] == $fieldName) {
                    unset($sortings[$k]);
                    break;
                }
            }
            array_unshift($sortings, ['field' => $fieldName, 'dir' => $dir]);
        }
        foreach ($sortings as $sorting) {
            $this->collection->addOrder($sorting['field'], $sorting['dir']);
        }
        return $sortings;
    }

    /**
     * @param array $collectionData
     * @return array
     */
    protected function processData($collectionData)
    {
        return $collectionData;
    }

    /**
     * @return void
     */
    protected function execute()
    {
        $this->block->setBookmarks(
            [
                AbstractGrid::BOOKMARK_FILTER  => $this->processFilters($this->request->getParam('filter')),
                AbstractGrid::BOOKMARK_SORTING => $this->processSorting($this->request->getParam('sorting'))
            ]
        );

        $this->collection->setPageSize($this->request->getParam('limit') ?: self::DEFAULT_PAGE_SIZE);

        if (($page = $this->request->getParam('p'))) {
            $this->collection->setCurrentPage($page);
        }

        $this->response->setType(Response::TYPE_JSON)->setData($this->processData($this->collection->toArray()));
    }

    /**
     * @return void
     */
    abstract protected function construct();
}
