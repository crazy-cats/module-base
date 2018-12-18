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
            <?php if ( $this->isMultiple() ) : ?>multiple="true" size="8"<?php endif; ?>>
                <?php
                if ( !empty( $field['options'] ) ) :
                    echo selectOptionsHtml( $field['options'], $value );
                endif;
                ?>
    </select>
    <?php if ( $this->withWrapper() ) : ?>
    </div>
<?php endif; ?>