<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend\Config;

use CrazyCat\Base\Model\Config;
use CrazyCat\Framework\App\Component\Module\Controller\Backend\Context;
use CrazyCat\Framework\App\Component\Module\Manager as ModuleManager;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Bruce Z <152416319@qq.com>
 * @link     https://crazy-cat.cn
 */
class Save extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @var \CrazyCat\Base\Model\Config
     */
    protected $dbConfig;

    /**
     * @var \CrazyCat\Framework\App\Component\Module\Manager
     */
    protected $moduleManager;

    public function __construct(Config $dbConfig, ModuleManager $moduleManager, Context $context)
    {
        parent::__construct($context);

        $this->dbConfig = $dbConfig;
        $this->moduleManager = $moduleManager;
    }

    /**
     * @return void
     */
    protected function execute()
    {
        try {
            list($scope, $scopeId) = array_pad(explode('-', $this->request->getPost('scope')), 2, 0);
            $data = $this->request->getPost('data');
            $this->dbConfig->saveConfig($data, $scope, $scopeId);
            $this->messenger->addSuccess(__('Configurations saved successfully.'));
        } catch (\Exception $e) {
            $this->messenger->addError($e->getMessage());
        }

        $this->redirect('system/config');
    }
}
