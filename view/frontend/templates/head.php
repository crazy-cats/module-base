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
            text: '<?php echo getStaticUrl( 'CrazyCat\Core::js/text' ); ?>'
        }
    } );
</script>