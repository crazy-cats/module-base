<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Backend;

use CrazyCat\Base\Block\Form\Renderer\File as FileRenderer;
use CrazyCat\Base\Block\Form\Renderer\Hidden as HiddenRenderer;
use CrazyCat\Base\Block\Form\Renderer\Image as ImageRenderer;
use CrazyCat\Base\Block\Form\Renderer\Password as PasswordRenderer;
use CrazyCat\Base\Block\Form\Renderer\Select as SelectRenderer;
use CrazyCat\Base\Block\Form\Renderer\Text as TextRenderer;
use CrazyCat\Base\Block\Form\Renderer\Textarea as TextareaRenderer;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
abstract class AbstractEdit extends \CrazyCat\Framework\App\Component\Module\Block\AbstractBlock
{
    /**
     * field types
     */
    public const FIELD_TYPE_EDITOR = 'editor';
    public const FIELD_TYPE_FILE = 'file';
    public const FIELD_TYPE_HIDDEN = 'hidden';
    public const FIELD_TYPE_IMAGE = 'image';
    public const FIELD_TYPE_MULTISELECT = 'multiselect';
    public const FIELD_TYPE_PASSWORD = 'password';
    public const FIELD_TYPE_SELECT = 'select';
    public const FIELD_TYPE_TEXT = 'text';
    public const FIELD_TYPE_TEXTAREA = 'textarea';

    protected $template = 'CrazyCat\Base::edit';

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);

        $this->objectManager = $context->getObjectManager();
    }

    /**
     * @param array $field
     * @param mixed $value
     * @return mixed
     */
    protected function getFieldValue(array $field, $value = null)
    {
        return ($value === null) ?
            ($this->getModel()->hasData($field['name']) ?
                $this->getModel()->getData($field['name']) :
                (isset($field['default_value']) ? $field['default_value'] : null)) :
            $value;
    }

    /**
     * @return \CrazyCat\Framework\App\Component\Module\Model\AbstractModel
     */
    public function getModel()
    {
        return $this->registry->registry('current_model');
    }

    /**
     * @param array $field
     * @param mixed $value
     * @return string
     * @throws \ReflectionException
     */
    public function renderField($field, $value = null)
    {
        if (isset($field['renderer'])) {
            $renderer = $this->objectManager->create($field['renderer']);
        } else {
            switch ($field['type']) {
                case self::FIELD_TYPE_FILE:
                    $renderer = $this->objectManager->create(FileRenderer::class);
                    break;

                case self::FIELD_TYPE_HIDDEN:
                    $renderer = $this->objectManager->create(HiddenRenderer::class);
                    break;

                case self::FIELD_TYPE_IMAGE:
                    $renderer = $this->objectManager->create(ImageRenderer::class);
                    break;

                case self::FIELD_TYPE_PASSWORD:
                    $renderer = $this->objectManager->create(PasswordRenderer::class);
                    break;

                case self::FIELD_TYPE_SELECT:
                case self::FIELD_TYPE_MULTISELECT:
                    $renderer = $this->objectManager->create(SelectRenderer::class)
                        ->isMultiple($field['type'] == self::FIELD_TYPE_MULTISELECT);
                    $options = isset($field['options'])
                        ? $field['options']
                        : (
                        isset($field['source'])
                            ? $this->objectManager->create($field['source'])->toOptionArray()
                            : []
                        );
                    $renderer->setData('options', $options);
                    break;

                case self::FIELD_TYPE_TEXT:
                    $renderer = $this->objectManager->create(TextRenderer::class);
                    break;

                case self::FIELD_TYPE_TEXTAREA:
                case self::FIELD_TYPE_EDITOR:
                    $renderer = $this->objectManager->create(TextareaRenderer::class);
                    break;
            }
        }

        return $renderer->addData(
            [
                'name'  => $field['name'],
                'field' => $field,
                'value' => $this->getFieldValue($field, $value)
            ]
        )
            ->setFieldNamePrefix('data')
            ->withLabel(true)
            ->withWrapper(true)
            ->toHtml();
    }

    /**
     * Return array structure is like:
     * [
     *     [
     *         'name'          => string,
     *         'label'         => string,
     *         'type'          => string,
     *         'renderer'      => string,
     *         'source'        => string,
     *         'options'       => array,
     *         'default_value' => mixed
     *     ]
     * ]
     *
     * @return array
     */
    abstract public function getFields();

    /**
     * @return string
     */
    abstract public function getActionUrl();
}
