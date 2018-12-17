<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

use CrazyCat\Core\Block\Backend\AbstractEdit;

/* @var $this \CrazyCat\Core\Block\Backend\AbstractEdit */
$fields = $this->getFields();
$model = $this->getModel();
?>
<div class="backend-edit">
    <form id="edit-form" method="post" action="<?php echo $this->getActionUrl(); ?>" enctype="multipart/form-data">
        <?php foreach ( $fields as $groupName => $fieldGroup ) : ?>
            <div class="field-group group-<?php echo $groupName ?>">
                <div class="field-group-label">
                    <?php echo __( $fieldGroup['label'] ) ?>
                </div>
                <div class="field-group-content">
                    <?php foreach ( $fieldGroup['fields'] as $field ) : ?>
                        <?php if ( $field['type'] === AbstractEdit::FIELD_TYPE_HIDDEN ) : ?>
                            <?php echo $this->renderField( $field ); ?>
                        <?php else : ?>
                            <div class="row">
                                <?php echo $this->renderField( $field ); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </form>
</div>

<script type="text/javascript">
    // <![CDATA[
    require( [ 'jquery', 'utility', 'CrazyCat/Core/js/validation' ], function( $, utility ) {
        var fields = <?php echo json_encode( $fields ); ?>;
        var multiValueTypes = [ '<?php echo AbstractEdit::FIELD_TYPE_MULTISELECT; ?>' ];
        var options = {
            rules: {},
            invalidHandler: function() {
                utility.loading( false );
            }
        };
        for ( var i = 0; i < fields.length; i++ ) {
            if ( fields[i].validation ) {
                var fieldName = multiValueTypes.indexOf( fields[i].type ) ? ('data[' + fields[i].name + ']') : ('data[' + fields[i].name + '][]');
                options.rules[ fieldName ] = fields[i].validation;
            }
        }
        $( '#edit-form' ).validate( options );

        $( '.field-group-label' ).on( 'click', function() {
            $( this ).siblings( '.field-group-content' ).slideDown();
            $( this ).closest( '.field-group' ).siblings().find( '.field-group-content' ).slideUp();
        } ).eq( 0 ).click();
    } );
    // ]]>
</script>