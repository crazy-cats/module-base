<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Textarea */
$field = $this->getField();
$value = $this->getValue();
?>
<div class="row">
    <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
    <div class="field-content">
        <textarea class="input-text" id="data_<?php echo $field['name']; ?>" name="data[<?php echo $field['name']; ?>]"><?php echo htmlEscape( $value ) ?></textarea>
    </div>
</div>