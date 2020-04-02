<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Base\Block\Form\Renderer\Textarea */
$field = $this->getField();
$value = $this->getValue();
?>
<?php if ( $this->withLabel() ) : ?>
    <label class="field-name" for="<?php echo $this->getFieldId(); ?>"><?php echo $field['label']; ?></label>
<?php endif; ?>
<?php if ( $this->withWrapper() ) : ?>
    <div class="field-content">
    <?php endif; ?>
    <textarea class="input-text <?php echo $this->getClasses(); ?>" rows="8"
              id="<?php echo $this->getFieldId(); ?>"
              name="<?php echo $this->getFieldName(); ?>"
              <?php echo (!empty( $this->getData( 'placeholder' ) ) ) ? ( 'placeholder="' . htmlEscape( $this->getData( 'placeholder' ) ) . '"' ) : ''; ?>
              <?php
              foreach ( $this->getParams() as $k => $v ) :
                  echo sprintf( '%s="%s"', $k, htmlEscape( $v ) );
              endforeach;
              ?>><?php echo htmlEscape( $value ) ?></textarea>
              <?php if ( $this->withWrapper() ) : ?>
    </div>
<?php endif; ?>