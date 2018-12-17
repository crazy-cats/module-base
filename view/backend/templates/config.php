<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Core\Block\Backend\Config */
$settings = $this->getFields();
?>
<div class="backend-edit">
    <form id="edit-form" method="post" action="<?php echo $this->getActionUrl(); ?>" enctype="multipart/form-data">
        <input type="hidden" name="scope" value="<?php echo $this->getScope() ?>" />
        <?php foreach ( $settings as $groupName => $settingGroup ) : ?>
            <div class="field-group group-<?php echo $groupName ?>">
                <div class="field-group-label">
                    <?php echo __( $settingGroup['label'] ) ?>
                </div>
                <div class="field-group-content">
                    <?php foreach ( $settingGroup['fields'] as $fieldName => $field ) : ?>
                        <div class="row">
                            <?php echo $this->renderField( $field, $this->getConfig( $groupName . '/' . $fieldName ) ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </form>
</div>

<script type="text/javascript">
// <![CDATA[
    require( [ 'jquery' ], function( $ ) {
        $( '.field-group-label' ).on( 'click', function() {
            $( this ).siblings( '.field-group-content' ).slideDown();
            $( this ).closest( '.field-group' ).siblings().find( '.field-group-content' ).slideUp();
        } ).eq( 0 ).click();
    } );
// ]]>
</script>