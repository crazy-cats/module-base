<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Text */
$field = $this->getField();
$value = $this->getValue();
?>
<?php if ( $this->withLabel() ) : ?>
    <label class="field-name" for="<?php echo $this->getFieldId(); ?>"><?php echo $field['label']; ?></label>
<?php endif; ?>
<?php if ( $this->withWrapper() ) : ?>
    <div class="field-content">
    <?php endif; ?>
    <input type="text" class="input-text <?php echo $this->getClasses(); ?>"
           id="<?php echo $this->getFieldId(); ?>"
           name="<?php echo $this->getFieldName(); ?>"
           value="<?php echo htmlEscape( $value ) ?>"
           <?php echo (!empty( $this->getData( 'placeholder' ) ) ) ? ( 'placeholder="' . htmlEscape( $this->getData( 'placeholder' ) ) . '"' ) : ''; ?>
           <?php
           foreach ( $this->getParams() as $key => $value ) :
               echo sprintf( '%s="%s"', $key, htmlEscape( $value ) );
           endforeach;
           ?>
           />
           <?php if ( $this->withWrapper() ) : ?>
    </div>
<?php endif; ?>