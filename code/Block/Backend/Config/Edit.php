<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Backend\Config;

use CrazyCat\Base\Framework\Config;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Edit extends \CrazyCat\Base\Block\Backend\AbstractEdit
{
    protected $template = 'CrazyCat\Base::config';

    /**
     * @var \CrazyCat\Base\Framework\Config
     */
    protected $config;

    public function __construct(
        \CrazyCat\Base\Block\Backend\Context $context,
        \CrazyCat\Base\Framework\Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->config = $config;
    }

    /**
     * @param array $field
     * @param mixed $value
     * @return mixed
     */
    protected function getFieldValue(array $field, $value = null)
    {
        return $field['default'] ?? $value;
    }

    /**
     * @param string $path
     * @return mixed
     * @throws \Exception
     */
    public function getConfig($path)
    {
        [$scope, $scopeId] = array_pad(explode('-', $this->getScope()), 2, 0);
        return $this->config->getValue($path, $scope, $scopeId);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getFields()
    {
        [$scope] = explode('-', $this->getScope());

        $settings = [];
        foreach ($this->config->getSettings() as $groupName => $settingGroup) {
            if (!in_array($scope, $settingGroup['scopes'])) {
                continue;
            }
            $settings[$groupName]['label'] = __($settingGroup['label']);
            $settings[$groupName]['sort_order'] = $settingGroup['sort_order'];
            foreach ($settingGroup['fields'] as $fieldName => $field) {
                if (!in_array($scope, $field['scopes'])) {
                    continue;
                }
                $field['label'] = __($field['label']);
                $settings[$groupName]['fields'][$fieldName] = $field;
            }
        }
        uasort(
            $settings,
            function ($a, $b) {
                return $a['sort_order'] > $b['sort_order'] ? 1 : ($a['sort_order'] < $b['sort_order'] ? -1 : 0);
            }
        );

        return $settings;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->request->getParam('scope', Config::SCOPE_GLOBAL);
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('system/config/save');
    }
}
