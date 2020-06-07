<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block;

use CrazyCat\Framework\App\Component\Theme\Block\Context;
use CrazyCat\Framework\App\Component\Language\Translator;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class LanguageSwitcher extends \CrazyCat\Framework\App\Component\Module\Block\AbstractBlock
{
    protected $template = 'CrazyCat\Base::language_switcher';

    /**
     * @var \CrazyCat\Framework\App\Component\Language\Translator
     */
    protected $translator;

    public function __construct(Translator $translator, Context $context, array $data = [])
    {
        parent::__construct($context, $data);

        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->translator->getLanguages();
    }

    /**
     * @return string
     */
    public function getCurrentLangCode()
    {
        return $this->translator->getLangCode();
    }
}
