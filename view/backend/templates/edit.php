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
            echo $this->renderField( $field );
        endforeach;
        ?>
    </form>

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
        } );
        // ]]>
    </script>
</div>