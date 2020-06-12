<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Form\Renderer\File */
$field = $this->getField();
$value = $this->getValue();
?>
<?php if ($this->withLabel()) : ?>
    <label class="field-name" for="<?= $this->getFieldId(); ?>"><?= $field['label']; ?></label>
<?php endif; ?>
<?php if ($this->withWrapper()) : ?>
    <div class="field-content">
<?php endif; ?>
<?php if ($value) : ?>
    <div class="file">
        <a target="_blank" href="<?= htmlEscape($this->getFileUrl()) ?>">
            <?= $value ?>
        </a>
        <input type="hidden"
               name="<?= htmlEscape($this->getFieldName()) ?>"
               value="<?= htmlEscape($value) ?>">
        <input type="checkbox"
               id="<?= $this->getFieldId(); ?>-remove"
               name="<?= htmlEscape($this->getFieldName()) ?>[remove]"/>
        <label for="<?= $this->getFieldId(); ?>-remove"><?= __('Remove') ?></label>
    </div>
<?php endif; ?>
    <div class="input-box">
        <input type="file"
               class="input-file <?= $this->getClasses() ?>"
               id="<?= $this->getFieldId() ?>"
               name="<?= htmlEscape($this->getFieldName()) ?>"
            <?php
            foreach ($this->getParams() as $k => $v) :
                echo sprintf('%s="%s"', $k, htmlEscape($v));
            endforeach;
            ?> />
    </div>
<?php if ($this->withWrapper()) : ?>
    </div>
<?php endif; ?>