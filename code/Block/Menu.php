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

        $html = '<ul>';
        foreach ( $menuData as $menuItem ) {
            $html .= sprintf( '<li class="level-%s %s"><a href="%s"><span>%s</span></a>%s</li>', $level, $menuItem['identifier'], $menuItem['url'], $menuItem['label'], !empty( $menuItem['children'] ) ? $this->getMenuHtml( $menuItem['children'], $level + 1 ) : '' );
        }
        $html .= '</ul>';
        return $html;
    }

}
