<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Select */
$field = $this->getField();
$value = $this->getValue();
?>
<?php if ( $this->withLabel() ) : ?>
    <label class="field-name" for="<?php echo $this->getFieldId(); ?>"><?php echo $field['label']; ?></label>
<?php endif; ?>
<?php if ( $this->withWrapper() ) : ?>
    <div class="field-content">
    <?php endif; ?>
    <select id="<?php echo $this->getFieldId(); ?>"
            name="<?php echo $this->getFieldName(); ?>"
            class="<?php echo $this->getClasses(); ?>"
            <?php if ( $this->isMultiple() ) : ?>multiple="true" size="8"<?php endif; ?>
            <?php
            foreach ( $this->getParams() as $key => $value ) :
                echo sprintf( '%s="%s"', $key, htmlEscape( $value ) );
            endforeach;
            ?>>
                <?php echo selectOptionsHtml( $this->getOptions(), $value ); ?>
    </select>
    <?php if ( $this->withWrapper() ) : ?>
    </div>
<?php endif; ?>