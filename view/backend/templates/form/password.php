<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Password */
$field = $this->getField();
?>
<?php if ( $this->getWithLabel() ) : ?>
    <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
<?php endif; ?>
<?php if ( $this->getWithWrapper() ) : ?>
    <div class="field-content">
        <input type="password" class="input-text" autocomplete="off"
               id="data_<?php echo $field['name']; ?>"
               name="data[<?php echo $field['name']; ?>]"
               <?php echo (!empty( $this->getData( 'placeholder' ) ) ) ? ( 'placeholder="' . htmlEscape( $this->getData( 'placeholder' ) ) . '"' ) : ''; ?> />
    </div>
<?php endif; ?>