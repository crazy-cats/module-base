<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Template */
if (empty($buttons = $this->getData('buttons'))) {
    return;
}
?>
<div class="block block-header-buttons">
    <div class="block-content">
        <?php foreach ($buttons as $name => $button) : ?>
            <button class="button btn-<?php echo $name ?>"
                    data-action="<?= htmlEscape(json_encode($button['action'])) ?>">
                <span><?php echo $button['label'] ?></span>
            </button>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
    // <![CDATA[
    require(['utility'], function (utility) {
        utility.actButton({wrapper: '.block-header-buttons'});
    });
    // ]]>
</script>