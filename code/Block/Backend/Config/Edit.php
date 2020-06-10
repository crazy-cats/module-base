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
     * @param array $field
     * @param mixed $value
     * @return mixed
     */
    protected function getFieldValue(array $field, $value = null)
    {
        return $value;
    }

    /**
     * @param string $path
     * @return mixed
     * @throws \ReflectionException
     */
    public function getConfig($path)
    {
        [$scope, $scopeId] = array_pad(explode('-', $this->getScope()), 2, 0);
        return $this->objectManager->get(Config::class)->getValue($path, $scope, $scopeId);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getFields()
    {
        $settings = [];
        [$scope] = explode('-', $this->getScope());
        foreach ($this->moduleManager->getEnabledModules() as $module) {
            if (isset($module->getData('config')['settings'])) {
                foreach ($module->getData('config')['settings'] as $groupName => $settingGroup) {
                    if (!in_array($scope, $settingGroup['scopes'])) {
                        continue;
                    }
                    if (!isset($settings[$groupName])) {
                        $settings[$groupName] = [
                            'fields' => []
                        ];
                    }
                    if (isset($settingGroup['label'])) {
                        $settings[$groupName]['label'] = $settingGroup['label'];
                    }
                    if (isset($settingGroup['sort_order'])) {
                        $settings[$groupName]['sort_order'] = $settingGroup['sort_order'];
                    }
                    $fields = [];
                    foreach ($settingGroup['fields'] as $fieldName => $field) {
                        if (!in_array($scope, $field['scopes'])) {
                            continue;
                        }
                        $field['name'] = $groupName . '/' . $fieldName;
                        $field['label'] = __($field['label']);
                        $fields[$fieldName] = $field;
                    }
                    $settings[$groupName]['fields'] = array_merge(
                        $settings[$groupName]['fields'],
                        $fields
                    );
                }
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
