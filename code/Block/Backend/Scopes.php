<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block\Backend;

use CrazyCat\Framework\App\Area;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Scopes extends \CrazyCat\Framework\App\Component\Module\Block\AbstractBlock
{
    protected $template = 'CrazyCat\Base::scopes';

    /**
     * @var \CrazyCat\Base\Model\Source\Scope
     */
    protected $sourceScope;

    public function __construct(
        \CrazyCat\Base\Model\Source\Scope $sourceScope,
        \CrazyCat\Framework\App\Component\Theme\Block\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->sourceScope = $sourceScope;
    }

    /**
     * return array
     */
    public function getScopeOptions()
    {
        return $this->sourceScope->toOptionArray();
    }

    /**
     * return string
     */
    public function getCurrentScope()
    {
        return $this->request->getParam('scope', Area::CODE_GLOBAL);
    }
}
