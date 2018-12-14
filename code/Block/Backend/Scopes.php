<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Block\Backend;

use CrazyCat\Core\Model\Source\Scope as SourceScope;
use CrazyCat\Framework\App\Area;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Scopes extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Core::scopes';

    /**
     * @var \CrazyCat\Core\Model\Source\Scope
     */
    protected $sourceScope;

    public function __construct( SourceScope $sourceScope, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->sourceScope = $sourceScope;
    }

    public function getScopeOptions()
    {
        return $this->sourceScope->toOptionsArray();
    }

    public function getCurrentScope()
    {
        return $this->request->getParam( 'scope', Area::CODE_GLOBAL );
    }

}
