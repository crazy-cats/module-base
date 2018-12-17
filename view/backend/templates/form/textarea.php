<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Textarea */
$field = $this->getField();
$value = $this->getValue();
?>
<?php if ( $this->getWithLabel() ) : ?>
    <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
<?php endif; ?>
<?php if ( $this->getWithWrapper() ) : ?>
    <div class="field-content">
        <textarea class="input-text" id="data_<?php echo $field['name']; ?>"
                  name="data[<?php echo $field['name']; ?>]"
                  <?php echo (!empty( $this->getData( 'placeholder' ) ) ) ? ( 'placeholder="' . htmlEscape( $this->getData( 'placeholder' ) ) . '"' ) : ''; ?>><?php echo htmlEscape( $value ) ?></textarea>
    </div>
<?php endif; ?>