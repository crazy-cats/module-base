<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Backend\Scopes */
?>
<div class="block block-scopes">
    <div class="block-content">
        <form method="get" action="<?= getUrl('system/config/index') ?>">
            <select name="scope">
                <?= selectOptionsHtml($this->getScopeOptions(), $this->getCurrentScope()); ?>
            </select>
        </form>
    </div>
</div>

<script type="text/javascript">
    // <![CDATA[
    require(['jquery'], function ($) {
        $('.block-scopes select').on('change', function () {
            $(this).closest('form').submit();
        });
    });
    // ]]>
</script>