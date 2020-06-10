<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model\Source;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Languages extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    public function __construct(
        \CrazyCat\Framework\App\Component\Language\Translator $translator
    ) {
        foreach ($translator->getLanguages() as $language) {
            $this->sourceData[$language['name']] = $language['code'];
        }
    }
}
