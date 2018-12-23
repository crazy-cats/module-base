<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Core\Block\Template */
?>
<script type="text/javascript" src="<?php echo getStaticUrl( 'CrazyCat\Core::js/require.js' ); ?>"></script>
<script type="text/javascript">
    require.config( {
        baseUrl: '<?php echo getStaticUrl( '' ); ?>',
        waitSeconds: 0,
        paths: {
            jquery: '<?php echo getStaticUrl( 'CrazyCat\Core::js/jquery' ); ?>',
            text: '<?php echo getStaticUrl( 'CrazyCat\Core::js/text' ); ?>',
            utility: '<?php echo getStaticUrl( 'CrazyCat\Core::js/utility' ); ?>',
            translator: '<?php echo getStaticUrl( 'CrazyCat\Core::js/translator' ); ?>',
            editor: '<?php echo getStaticUrl( 'CrazyCat/Core/js/tinymce/tinymce.min' ); ?>'
        },
        shim: {
            editor: {
                exports: 'tinymce'
            }
        }
    } );
</script>