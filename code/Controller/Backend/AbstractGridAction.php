<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Index\Controller\Backend;

use CrazyCat\Framework\App\Io\Http\Response;
use CrazyCat\Framework\App\Module\Controller\Backend\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Framework
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
abstract class AbstractGridAction extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    const DEFAULT_PAGE_SIZE = 20;

    /**
     * @var \CrazyCat\Index\Block\Backend\AbstractGrid
     */
    protected $block;

    /**
     * @var \CrazyCat\Framework\App\Module\Model\AbstractCollection
     */
    protected $collection;

    public function __construct( Context $context )
    {
        parent::__construct( $context );

        $this->construct();
    }

    /**
     * @param string $collectionClass
     */
    protected function init( $collectionClass, $blockClass )
    {
        $this->block = $this->objectManager->create( $blockClass );
        $this->collection = $this->objectManager->create( $collectionClass );
    }

    /**
     * @return void
     */
    protected function run()
    {
        $this->collection->setPageSize( $this->request->getParams( 'limit' ) ?: self::DEFAULT_PAGE_SIZE  );

        if ( ( $page = $this->request->getParams( 'p' ) ) ) {
            $this->collection->setCurrentPage( $page );
        }

        $this->response->setType( Response::TYPE_JSON )->setData( $this->collection->toArray() );
    }

    /**
     * @return void
     */
    abstract protected function construct();
}
