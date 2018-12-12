<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Index\Block;

/**
 * @category CrazyCat
 * @package CrazyCat\Index
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Menu extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Index::menu';

    /**
     * @return array
     */
    protected function getMenuData()
    {
        return [];
    }

    /**
     * @param array $menuData
     * @param int $level
     * @return string
     */
    public function getMenuHtml( $menuData = null, $level = 1 )
    {
        if ( $menuData === null ) {
            $menuData = $this->getMenuData();
        }

        $html = '<ul class="level-' . $level . '">';
        foreach ( $menuData as $menuItem ) {
            $itemClass = 'level-' . $level . ' item-' . preg_replace( '/[^A-Za-z\d]+/', '-', $menuItem['identifier'] );
            $linkClass = ( ( isset( $menuItem['url'] ) && $this->url->isCurrent( $menuItem['url'] ) ) ? 'class="current"' : '' );
            $href = ( empty( $menuItem['url'] ) ? 'javascript:;' : $menuItem['url'] );
            $childHtml = !empty( $menuItem['children'] ) ? $this->getMenuHtml( $menuItem['children'], $level + 1 ) : '';
            $html .= sprintf( '<li class="%s"><a %s href="%s"><span>%s</span></a>%s</li>', $itemClass, $linkClass, $href, $menuItem['label'], $childHtml );
        }
        $html .= '</ul>';

        return $html;
    }

}
