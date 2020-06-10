<?php


namespace CrazyCat\Base\Model\Source;

use \CrazyCat\Framework\App\Area;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Themes extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    /**
     * @throws \Exception
     */
    public function __construct(
        \CrazyCat\Framework\App\Component\Theme\Manager $themeManager
    ) {
        foreach ($themeManager->getThemes(Area::CODE_FRONTEND) as $theme) {
            $this->sourceData[$theme->getData('name')] = $theme->getData('name');
        }
    }
}
