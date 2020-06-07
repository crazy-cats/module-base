<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Form\Renderer\Select */
$field = $this->getField();
$value = $this->getValue();
?>
<?php if ($this->withLabel()) : ?>
    <label class="field-name" for="<?= $this->getFieldId(); ?>"><?= $field['label']; ?></label>
<?php endif; ?>
<?php if ($this->withWrapper()) : ?>
    <div class="field-content">
<?php endif; ?>
    <select id="<?= $this->getFieldId(); ?>"
            name="<?= $this->getFieldName(); ?>"
            class="<?= $this->getClasses(); ?>"
            <?php if ($this->isMultiple()) :
                ?>multiple="true" size="8"<?php
            endif; ?>
        <?php
        foreach ($this->getParams() as $k => $v) :
            echo sprintf('%s="%s"', $k, htmlEscape($v));
        endforeach;
        ?>>
        <?= selectOptionsHtml($this->getOptions(), $value); ?>
    </select>
<?php if ($this->withWrapper()) : ?>
    </div>
<?php endif; ?>