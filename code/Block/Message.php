<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Index\Block;

use CrazyCat\Framework\App\Session\Messenger;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Index
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Message extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Index::message';

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
