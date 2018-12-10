<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

use CrazyCat\Framework\App\Module\Block\Backend\AbstractEdit;

/* @var $this \CrazyCat\Framework\App\Module\Block\Backend\AbstractEdit */
$fields = $this->getFields();
$model = $this->getModel();
?>
<div class="backend-edit">
    <form id="edit-form" method="post" action="<?php echo $this->getActionUrl(); ?>" enctype="multipart/form-data">
        <?php
        foreach ( $fields as $field ) :
            switch ( $field['type'] ) :

                case AbstractEdit::FIELD_TYPE_HIDDEN :
                    ?>
                    <input type="hidden" name="data[<?php echo $field['name']; ?>]" value="<?php echo htmlEscape( $model->getData( $field['name'] ) ); ?>" />
                    <?php
                    break;

                case AbstractEdit::FIELD_TYPE_MULTISELECT :
                    ?>
                    <div class="row">
                        <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
                        <div class="field-content">
                            <select id="data_<?php echo $field['name']; ?>" name="data[<?php echo $field['name'] ?>]" multiple="true" size="8">
                                <?php
                                if ( !empty( $field['options'] ) ) :
                                    foreach ( $field['options'] as $option ) :
                                        ?>
                                        <option value="<?php echo htmlEscape( $option['value'] ) ?>"
                                                <?php echo ( is_array( $model->getData( $field['name'] ) ) && in_array( $option['value'], $model->getData( $field['name'] ) ) ) ? 'selected="selected"' : '' ?>>
                                                    <?php echo htmlEscape( $option['label'] ) ?>
                                        </option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                    break;

                case AbstractEdit::FIELD_TYPE_PASSWORD :
                    ?>
                    <div class="row">
                        <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
                        <div class="field-content">
                            <input type="password" class="input-text" id="data_<?php echo $field['name']; ?>" name="data[<?php echo $field['name']; ?>]" autocomplete="off" />
                        </div>
                    </div>
                    <?php
                    break;

                case AbstractEdit::FIELD_TYPE_SELECT :
                    ?>
                    <div class="row">
                        <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
                        <div class="field-content">
                            <select id="data_<?php echo $field['name']; ?>" name="data[<?php echo $field['name'] ?>]">
                                <?php
                                if ( !empty( $field['options'] ) ) :
                                    foreach ( $field['options'] as $option ) :
                                        ?>
                                        <option value="<?php echo htmlEscape( $option['value'] ) ?>"
                                                <?php echo ( $model->getData( $field['name'] ) == $option['value'] ) ? 'selected="selected"' : '' ?>>
                                                    <?php echo htmlEscape( $option['label'] ) ?>
                                        </option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                    break;

                case AbstractEdit::FIELD_TYPE_TEXT :
                    ?>
                    <div class="row">
                        <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
                        <div class="field-content">
                            <input type="text" class="input-text" id="data_<?php echo $field['name']; ?>" name="data[<?php echo $field['name']; ?>]" value="<?php echo htmlEscape( $model->getData( $field['name'] ) ) ?>" />
                        </div>
                    </div>
                    <?php
                    break;

                case AbstractEdit::FIELD_TYPE_TEXTAREA :
                    ?>
                    <div class="row">
                        <label class="field-name" for="data_<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
                        <div class="field-content">
                            <textarea class="input-text" id="data_<?php echo $field['name']; ?>" name="data[<?php echo $field['name']; ?>]"><?php echo htmlEscape( $model->getData( $field['name'] ) ) ?></textarea>
                        </div>
                    </div>
                    <?php
                    break;

            endswitch;
        endforeach;
        ?>
    </form>
</div>