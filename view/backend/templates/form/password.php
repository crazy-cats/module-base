<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Base\Block\Form\Renderer\Password */
$field = $this->getField();
?>
<?php if ( $this->withLabel() ) : ?>
    <label class="field-name" for="<?php echo $this->getFieldId(); ?>"><?php echo $field['label']; ?></label>
<?php endif; ?>
<?php if ( $this->withWrapper() ) : ?>
    <div class="field-content">
    <?php endif; ?>
    <input type="password" autocomplete="off"
           class="input-text <?php echo $this->getClasses(); ?>"
           id="<?php echo $this->getFieldId(); ?>"
           name="<?php echo $this->getFieldName(); ?>"
           <?php echo (!empty( $this->getData( 'placeholder' ) ) ) ? ( 'placeholder="' . htmlEscape( $this->getData( 'placeholder' ) ) . '"' ) : ''; ?>
           <?php
           foreach ( $this->getParams() as $k => $v ) :
               echo sprintf( '%s="%s"', $k, htmlEscape( $v ) );
           endforeach;
           ?> />
           <?php if ( $this->withWrapper() ) : ?>
    </div>
<?php endif; ?>