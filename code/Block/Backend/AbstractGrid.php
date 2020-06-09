<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Backend;

use CrazyCat\Base\Block\Form\Renderer\Select as SelectRenderer;
use CrazyCat\Base\Block\Form\Renderer\Text as TextRenderer;
use CrazyCat\Framework\Utility\StaticVariable;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
abstract class AbstractGrid extends \CrazyCat\Framework\App\Component\Module\Block\AbstractBlock
{
    public const BOOKMARK_FILTER = 'filter';
    public const BOOKMARK_SORTING = 'sorting';

    /**
     * field types
     */
    public const FIELD_TYPE_SELECT = 'select';
    public const FIELD_TYPE_TEXT = 'text';

    protected $template = 'CrazyCat\Base::grid';

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \CrazyCat\Framework\App\Io\Http\Session\Backend
     */
    protected $session;

    /**
     * @var array
     */
    protected $bookmarks;

    public function __construct(
        \CrazyCat\Base\Block\Backend\Context $context,
        \CrazyCat\Framework\App\Io\Http\Session\Backend $session,
        \CrazyCat\Framework\App\ObjectManager $objectManager,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->objectManager = $objectManager;
        $this->session = $session;
    }

    /**
     * @param array $options
     * @return array
     */
    protected function processOptions($options)
    {
        /**
         * PHP transforms all request variables to string type,
         *     so we need to process the option value for comparison purposes.
         */
        foreach ($options as &$option) {
            if (is_numeric($option['value'])) {
                $option['value'] = (string)$option['value'];
            }
        }
        return $options;
    }

    /**
     * @return array
     */
    public function getBookmarks()
    {
        if ($this->bookmarks === null) {
            $this->bookmarks = $this->session->getGridBookmarks(static::BOOKMARK_KEY) ?:
                [self::BOOKMARK_FILTER => [], self::BOOKMARK_SORTING => []];
        }
        return $this->bookmarks;
    }

    /**
     * @param array $bookmarks
     * @return $this
     */
    public function setBookmarks(array $bookmarks)
    {
        $this->session->setGridBookmarks(static::BOOKMARK_KEY, $bookmarks);
        return $this;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->getBookmarks()[self::BOOKMARK_FILTER];
    }

    /**
     * @return array
     */
    public function getSortings()
    {
        return $this->getBookmarks()[self::BOOKMARK_SORTING];
    }

    /**
     * @param string $fieldName
     * @return array|null
     */
    public function getSorting($fieldName)
    {
        foreach ($this->getBookmarks()[self::BOOKMARK_SORTING] as $sorting) {
            if ($sorting['field'] == $fieldName) {
                return $sorting;
            }
        }
        return null;
    }

    /**
     * @param array $field
     * @param mixed $value
     * @return string
     * @throws \ReflectionException
     */
    public function renderFilter($field)
    {
        if (isset($field['ids'])) {
            return '<input type="checkbox" class="input-ids" data-selector=".input-ids" />';
        } elseif (isset($field['actions'])) {
            return '&nbsp;';
        } elseif (!isset($field['filter'])) {
            return '&nbsp;';
        }

        switch ($field['filter']['type']) {
            case self::FIELD_TYPE_SELECT:
                $renderer = $this->objectManager->create(SelectRenderer::class);
                $options = isset($field['filter']['options']) ? $field['filter']['options'] :
                    (isset($field['filter']['source']) ? $this->objectManager->create(
                        $field['filter']['source']
                    )->toOptionArray() : []);
                array_unshift($options, ['label' => '', 'value' => StaticVariable::NO_SELECTION]);
                $renderer->setData('options', $this->processOptions($options));
                break;

            case self::FIELD_TYPE_TEXT:
                $renderer = $this->objectManager->create(TextRenderer::class);
                break;
        }

        $filters = $this->getFilters();
        $value = isset($filters[$field['name']]) ? $filters[$field['name']] : null;

        return $renderer->addData(['name' => 'filter_' . $field['name'], 'field' => $field, 'value' => $value])
            ->setFieldNamePrefix('filter')
            ->setClasses('filter-' . $field['name'])
            ->setParams(['data-selector' => '.filter-' . $field['name']])
            ->toHtml();
    }

    /**
     * Return array structure is like:
     * [
     *     [
     *         'name' => string,
     *         'label' => string,
     *         'sort' => boolean,
     *         'filter' => [
     *             'type' => string,
     *             'options' => array,
     *             'condition' => string
     *         ]
     *     ]
     * ]
     *
     * @return array
     */
    abstract public function getFields();

    /**
     * @return string
     */
    abstract public function getSourceUrl();
}
