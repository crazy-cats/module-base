<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Wrapper */

foreach ($this->getChildren() as $block):
    echo $block->toHtml();
endforeach;