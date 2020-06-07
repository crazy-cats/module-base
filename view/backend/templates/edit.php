<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

use CrazyCat\Base\Block\Backend\AbstractEdit;

/* @var $this \CrazyCat\Base\Block\Backend\AbstractEdit */
$fields = $this->getFields();
$model = $this->getModel();
?>
<div class="backend-edit">
    <form id="edit-form" method="post" action="<?= $this->getActionUrl(); ?>" enctype="multipart/form-data">
        <?php foreach ($fields as $groupName => $fieldGroup) : ?>
            <div class="field-group group-<?= $groupName ?>">
                <div class="field-group-label">
                    <?= __($fieldGroup['label']) ?>
                </div>
                <div class="field-group-content">
                    <?php foreach ($fieldGroup['fields'] as $field) : ?>
                        <?php if (isset($field['type']) && $field['type'] === AbstractEdit::FIELD_TYPE_HIDDEN) : ?>
                            <?= $this->renderField($field); ?>
                        <?php else : ?>
                            <div class="row">
                                <?= $this->renderField($field); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </form>
</div>

<script type="text/javascript">
    // <![CDATA[
    require(['CrazyCat/Base/js/form'], function (form) {
        form({
            el: '#edit-form',
            fields: <?= json_encode($fields); ?>,
            editor: {
                baseUrl: '<?= $this->getBaseUrl() ?>',
                imageUploadUrl: '<?= $this->getImageUploadUrl() ?>',
                skinUrl: '<?= $this->getStaticUrl('CrazyCat\Base::css/tinymce/skins/lightgray') ?>'
            }
        });
    });
    // ]]>
</script>