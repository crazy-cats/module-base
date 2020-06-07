<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Model\Stage;

/**
 * @category CrazyCat
 * @package  CrazyCat\Base
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Collection extends \CrazyCat\Framework\App\Component\Module\Model\AbstractCollection
{
    protected function construct()
    {
        $this->init(\CrazyCat\Base\Model\Stage::class);
    }
}
