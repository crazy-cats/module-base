<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Core\Block\Backend\Config */
$settings = $this->getSettings();
?>
<div class="settings">
    <form id="config-form" method="post" action="<?php echo getUrl( 'system/config/save' ) ?>">
        <?php foreach ( $settings as $groupName => $settingGroup ) : ?>
            <div class="setting-group group-<?php echo $groupName ?>">
                <div class="setting-group-label">
                    <?php echo __( $settingGroup['label'] ) ?>
                </div>
                <div class="setting-group-content">
                    <?php
                    foreach ( $settingGroup['fields'] as $fieldName => $field ) :
                        switch ( $field['type'] ) :

                            case 'hidden' :
                                ?>
                                <input type="hidden" name="data[<?php echo $groupName; ?>/<?php echo $fieldName; ?>]" value="<?php echo htmlEscape( $this->getConfig( $groupName . '/' . $fieldName ) ); ?>" />
                                <?php
                                break;

                            case 'multiselect' :
                                ?>
                                <div class="row">
                                    <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo __( $field['label'] ); ?></label>
                                    <div class="field-content">
                                        <select id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $groupName; ?>/<?php echo $fieldName ?>][]" multiple="true" size="8">
                                            <?php echo selectOptionsHtml( $this->getOptions( $field ), $this->getConfig( $groupName . '/' . $fieldName ) ); ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                break;

                            case 'password' :
                                ?>
                                <div class="row">
                                    <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo __( $field['label'] ); ?></label>
                                    <div class="field-content">
                                        <input type="password" class="input-text" id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $groupName; ?>/<?php echo $fieldName; ?>]" autocomplete="off" />
                                    </div>
                                </div>
                                <?php
                                break;

                            case 'select' :
                                ?>
                                <div class="row">
                                    <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo __( $field['label'] ); ?></label>
                                    <div class="field-content">
                                        <select id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $groupName; ?>/<?php echo $fieldName ?>]">
                                            <?php echo selectOptionsHtml( $this->getOptions( $field ), $this->getConfig( $groupName . '/' . $fieldName ) ); ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                break;

                            case 'text' :
                                ?>
                                <div class="row">
                                    <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo __( $field['label'] ); ?></label>
                                    <div class="field-content">
                                        <input type="text" class="input-text" id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $groupName; ?>/<?php echo $fieldName; ?>]" value="<?php echo htmlEscape( $this->getConfig( $groupName . '/' . $fieldName ) ) ?>" />
                                    </div>
                                </div>
                                <?php
                                break;

                            case 'textarea' :
                                ?>
                                <div class="row">
                                    <label class="field-name" for="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>"><?php echo __( $field['label'] ); ?></label>
                                    <div class="field-content">
                                        <textarea class="input-text" id="data_<?php echo $groupName; ?>_<?php echo $fieldName; ?>" name="data[<?php echo $groupName; ?>/<?php echo $fieldName; ?>]"><?php echo htmlEscape( $this->getConfig( $groupName . '/' . $fieldName ) ) ?></textarea>
                                    </div>
                                </div>
                                <?php
                                break;

                        endswitch;
                    endforeach;
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </form>
</div>

<script type="text/javascript">
// <![CDATA[
    require( [ 'jquery' ], function( $ ) {
        $( '.settings .setting-group-label' ).on( 'click', function() {
            $( this ).siblings( '.setting-group-content' ).slideDown();
            $( this ).closest( '.setting-group' ).siblings().find( '.setting-group-content' ).slideUp();
        } ).eq( 0 ).click();
    } );
// ]]>
</script>