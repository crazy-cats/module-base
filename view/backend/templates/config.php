<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Backend\Config\Edit */
$settings = $this->getFields();
?>
<div class="backend-edit">
    <form id="edit-form" method="post" action="<?= $this->getActionUrl(); ?>" enctype="multipart/form-data">
        <input type="hidden" name="scope" value="<?= $this->getScope() ?>"/>
        <?php foreach ($settings as $groupName => $settingGroup) : ?>
            <div class="field-group group-<?= $groupName ?>">
                <div class="field-group-label">
                    <?= __($settingGroup['label']) ?>
                </div>
                <div class="field-group-content">
                    <?php foreach ($settingGroup['fields'] as $field) : ?>
                        <div class="row">
                            <?= $this->renderField($field, $this->getConfig($field['name'])); ?>
                        </div>
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
            fields: <?= json_encode($settings); ?>,
            editor: {
                baseUrl: '<?= $this->getBaseUrl() ?>',
                imageUploadUrl: '<?= $this->getImageUploadUrl() ?>',
                skinUrl: '<?= $this->getStaticUrl('CrazyCat\Base::css/tinymce/skins/lightgray') ?>'
            }
        });
    });
    // ]]>
</script>