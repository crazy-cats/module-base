<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

use CrazyCat\Framework\App\Component\Manager as ComponentManager;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Bruce Z <152416319@qq.com>
 * @link     https://crazy-cat.cn
 */
ComponentManager::getInstance()->register('CrazyCat\Base', ComponentManager::TYPE_MODULE, __DIR__);
