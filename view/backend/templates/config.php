<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Core\Block\Backend\Config */
$settings = $this->getSettings();
?>
<div class="backend-edit">
    <dl>
        <?php foreach ( $settings as $groupName => $settingGroup ) : ?>
            <dt class="<?php echo $groupName ?>"><?php echo $settingGroup['label'] ?></dt>
            <dd class="<?php echo $groupName ?>">
                <?php
                foreach ( $settingGroup['fields'] as $fieldName => $field ) :
                    switch ( $field['type'] ) :

                        case AbstractEdit::FIELD_TYPE_HIDDEN :
                            ?>
                            <input type="hidden" name="data[<?php echo $groupName; ?>][<?php echo $fieldName; ?>]" value="<?php echo htmlEscape( $this->getConfig( $groupName . '/' . $fieldName ) ); ?>" />
                            <?php
                            break;

                        case AbstractEdit::FIELD_TYPE_MULTISELECT :
                            ?>
                            <div class="row">
                                <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo $field['label']; ?></label>
                                <div class="field-content">
                                    <select id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $fieldName ?>][]" multiple="true" size="8">
                                        <?php echo selectOptionsHtml( $this->getOptions( $field ), $this->getConfig( $groupName . '/' . $fieldName ) ); ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            break;

                        case AbstractEdit::FIELD_TYPE_PASSWORD :
                            ?>
                            <div class="row">
                                <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo $field['label']; ?></label>
                                <div class="field-content">
                                    <input type="password" class="input-text" id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $groupName; ?>][<?php echo $fieldName; ?>]" autocomplete="off" />
                                </div>
                            </div>
                            <?php
                            break;

                        case AbstractEdit::FIELD_TYPE_SELECT :
                            ?>
                            <div class="row">
                                <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo $field['label']; ?></label>
                                <div class="field-content">
                                    <select id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $fieldName ?>]">
                                        <?php echo selectOptionsHtml( $this->getOptions( $field ), $this->getConfig( $groupName . '/' . $fieldName ) ); ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            break;

                        case AbstractEdit::FIELD_TYPE_TEXT :
                            ?>
                            <div class="row">
                                <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo $field['label']; ?></label>
                                <div class="field-content">
                                    <input type="text" class="input-text" id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $groupName; ?>][<?php echo $fieldName; ?>]" value="<?php echo htmlEscape( $this->getConfig( $groupName . '/' . $fieldName ) ) ?>" />
                                </div>
                            </div>
                            <?php
                            break;

                        case AbstractEdit::FIELD_TYPE_TEXTAREA :
                            ?>
                            <div class="row">
                                <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo $field['label']; ?></label>
                                <div class="field-content">
                                    <textarea class="input-text" id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $groupName; ?>][<?php echo $fieldName; ?>]"><?php echo htmlEscape( $this->getConfig( $groupName . '/' . $fieldName ) ) ?></textarea>
                                </div>
                            </div>
                            <?php
                            break;

                    endswitch;
                endforeach;
                ?>
            </dd>
        <?php endforeach; ?>
    </dl>
</div>