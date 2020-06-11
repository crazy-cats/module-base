<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend\Config;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Save extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @var \CrazyCat\Base\Framework\Config
     */
    protected $scopeConfig;

    /**
     * @var \CrazyCat\Framework\App\Component\Module\Manager
     */
    protected $moduleManager;

    public function __construct(
        \CrazyCat\Base\Framework\Config $scopeConfig,
        \CrazyCat\Framework\App\Component\Module\Manager $moduleManager,
        \CrazyCat\Framework\App\Component\Module\Controller\Backend\Context $context
    ) {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfig;
        $this->moduleManager = $moduleManager;
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function execute()
    {
        [$scope, $scopeId] = array_pad(explode('-', $this->request->getPost('scope')), 2, 0);

        try {
            $data = $this->request->getPost('data');
            $this->scopeConfig->saveConfig($data, $scope, $scopeId);
            $this->messenger->addSuccess(__('Configurations saved successfully.'));
        } catch (\Exception $e) {
            $this->messenger->addError($e->getMessage());
        }

        $this->redirect('system/config', ['scope' => $scope . ($scopeId ? ('-' . $scopeId) : '')]);
    }
}
