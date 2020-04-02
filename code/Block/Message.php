<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Block;

use CrazyCat\Framework\App\Session\Messenger;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@com.com>
 * @link     https://crazy-cat.cn
 */
class Message extends \CrazyCat\Framework\App\Component\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Base::message';

    /**
     * @var \CrazyCat\Framework\App\Session\Messenger
     */
    protected $messenger;

    public function __construct( Messenger $messenger, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->messenger = $messenger;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messenger->getMessages( true );
    }

}
