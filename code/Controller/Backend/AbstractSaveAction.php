<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Backend;

use CrazyCat\Base\Block\Backend\AbstractGrid;
use CrazyCat\Framework\App\Io\Http\Response;
use CrazyCat\Framework\Utility\StaticVariable;

/**
 * @category CrazyCat
 * @package  CrazyCat\Framework
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
abstract class AbstractSaveAction extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @param string $fieldName
     * @param string $mediaFolder
     * @param array  $data
     * @return void
     */
    protected function processFile($fieldName, $mediaFolder, &$data)
    {
        if (isset($data[$fieldName]['remove'])) {
            $data[$fieldName] = null;
            return;
        }

        if (!empty($_FILES['data']['name'][$fieldName])) {
            $data[$fieldName] = $this->objectManager->get(\CrazyCat\Framework\Utility\File::class)
                ->renameByDate($_FILES['data']['name'][$fieldName]);
            $fileName = DIR_PUB . DS . 'media' . DS . $mediaFolder . DS . $data[$fieldName];
            $dir = dirname($fileName);
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
            move_uploaded_file($_FILES['data']['tmp_name'][$fieldName], $fileName);
        }
    }
}
