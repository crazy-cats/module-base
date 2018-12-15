<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
/* @var $this \CrazyCat\Core\Block\Form\Renderer\Select */
$field = $this->getField();
$value = $this->getValue();
?>
<div class="row">
    <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
    <div class="field-content">
        <select id="data_<?php echo $field['name']; ?>"
                name="data[<?php echo $field['name'] ?>]"
                <?php if ( $this->getIsMultiple() ) : ?>multiple="true" size="8"<?php endif; ?>>
                    <?php
                    if ( !empty( $field['options'] ) ) :
                        echo selectOptionsHtml( $field['options'], $value );
                    endif;
                    ?>
        </select>
    </div>
</div>