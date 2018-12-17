<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Password */
$field = $this->getField();
?>
<?php if ( $this->withLabel() ) : ?>
    <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
<?php endif; ?>
<?php if ( $this->withWrapper() ) : ?>
    <div class="field-content">
    <?php endif; ?>
    <input type="password" class="input-text" autocomplete="off"
           id="<?php echo $this->getFieldId(); ?>"
           name="<?php echo $this->getFieldName(); ?>"
           <?php echo (!empty( $this->getData( 'placeholder' ) ) ) ? ( 'placeholder="' . htmlEscape( $this->getData( 'placeholder' ) ) . '"' ) : ''; ?> />
           <?php if ( $this->withWrapper() ) : ?>
    </div>
<?php endif; ?>