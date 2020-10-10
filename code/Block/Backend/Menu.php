<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Backend;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Menu extends \CrazyCat\Framework\App\Component\Module\Block\AbstractBlock
{
    public const CACHE_KEY = 'backend_menu';

    protected $template = 'CrazyCat\Base::menu';

    /**
     * @var \CrazyCat\Framework\App\Component\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \CrazyCat\Admin\Model\Session
     */
    protected $session;

    /**
     * @var \CrazyCat\Framework\App\Component\Language\Translator
     */
    protected $translator;

    public function __construct(
        \CrazyCat\Framework\App\Component\Language\Translator $translator,
        \CrazyCat\Framework\App\Component\Module\Manager $moduleManager,
        \CrazyCat\Framework\App\Component\Theme\Block\Context $context,
        \CrazyCat\Framework\App\Io\Http\Session\Backend $session,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->moduleManager = $moduleManager;
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * @param array $menuData
     * @return void
     */
    protected function processIdentifier(&$menuData)
    {
        foreach ($menuData as $identifier => &$itemData) {
            $itemData['identifier'] = $identifier;
            if (isset($itemData['children']) && is_array($itemData)) {
                $this->processIdentifier($itemData['children']);
            }
        }
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function getFullMenuData()
    {
        $menuData = [];
        foreach ($this->moduleManager->getEnabledModules() as $module) {
            if (is_file(($file = $module->getData('dir') . DS . 'config' . DS . 'backend' . DS . 'menu.php')) &&
                is_array(($moduleMenuData = require $file))) {
                $menuData = array_merge_recursive($menuData, $moduleMenuData);
            }
        }
        $this->processIdentifier($menuData);
        usort(
            $menuData,
            function ($a, $b) {
                return $a['sort_order'] > $b['sort_order'] ? 1 : ($a['sort_order'] < $b['sort_order'] ? -1 : 0);
            }
        );
        return $menuData;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function getMenuData()
    {
        if (!$this->session->getAdmin()) {
            return [];
        }

        $sourceData = $this->getFullMenuData();
        if ($this->session->getAdmin()->getRole()->getIsSuper()) {
            return $sourceData;
        }

        $menuData = [];
        $permissions = $this->session->getAdmin()->getRole()->getPermissions();
        foreach ($sourceData as $itemData) {
            /**
             * Show level 1 item only on at least one child item is in permissions,
             *     if related child item exist.
             */
            if (isset($itemData['children'])) {
                $children = [];
                foreach ($itemData['children'] as $childData) {
                    if (in_array($childData['identifier'], $permissions)) {
                        $children[] = $childData;
                    }
                }
                if (!empty($children)) {
                    $menuData[] = [
                        'label'      => $itemData['label'],
                        'identifier' => $itemData['identifier'],
                        'children'   => $children
                    ];
                }
            } else {
                /**
                 * Check permission with level 1 item if no child item set.
                 */
                if (in_array($itemData['identifier'], $permissions)) {
                    $menuData[] = $itemData;
                }
            }
        }

        return $menuData;
    }

    /**
     * @param array|null $menuData
     * @param int        $level
     * @return string
     * @throws \ReflectionException
     */
    public function getMenuHtml($menuData = null, $level = 1)
    {
        if ($menuData === null) {
            $menuData = $this->getMenuData();
        }

        $html = '<ul class="level-' . $level . '">';
        foreach ($menuData as $menuItem) {
            $url = !empty($menuItem['url']) ? $this->url->getUrl($menuItem['url']) : null;
            $childHtml = !empty($menuItem['children']) ? $this->getMenuHtml($menuItem['children'], $level + 1) : '';
            $itemClass = 'level-' . $level . ' item-'
                . preg_replace('/[^A-Za-z\d]+/', '-', $menuItem['identifier'])
                . ($childHtml ? ' parent' : '');
            $linkClass = (($url !== null && $this->url->isCurrent($url)) ? 'class="current"' : '');
            $href = ($url === null ? 'javascript:;' : $url);
            $html .= sprintf(
                '<li class="%s"><a %s href="%s"><span>%s</span></a>%s</li>',
                $itemClass,
                $linkClass,
                $href,
                __($menuItem['label']),
                $childHtml
            );
        }
        $html .= '</ul>';

        return $html;
    }
}
