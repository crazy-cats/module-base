<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Block;

use CrazyCat\Framework\App\Theme\Block\Context;
use CrazyCat\Framework\App\Translator;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class LanguageSwitcher extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Core::language_switcher';

    /**
     * @var \CrazyCat\Framework\App\Translator
     */
    protected $translator;

    public function __construct( Translator $translator, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

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
