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
    require( [ 'CrazyCat/Core/js/form' ], function( form ) {
        form( {
            el: '#edit-form',
            fields: <?php echo json_encode( $fields ); ?>,
            editor: {
                baseUrl: '<?php echo getBaseUrl() ?>',
                imageUploadUrl: '<?php echo $this->getImageUploadUrl() ?>',
                skinUrl: '<?php echo getStaticUrl( 'CrazyCat\Core::css/tinymce/skins/lightgray' ) ?>'
            }
        } );
    } );
    // ]]>
</script>