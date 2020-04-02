<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Head */
?>
<script type="text/javascript" src="<?php echo getStaticUrl( 'CrazyCat\Base::js/require.js' ); ?>"></script>
<script type="text/javascript">
    // <![CDATA[
    window.languageCode = '<?php echo $this->getLangCode(); ?>';
    window.localStoragePrefix = '<?php echo $this->getLocalStoragePrefix(); ?>';

    require.config( {
        baseUrl: '<?php echo getStaticUrl( '' ); ?>',
        waitSeconds: 0,
        paths: {
            jquery: '<?php echo getStaticUrl( 'CrazyCat\Base::js/jquery' ); ?>',
            text: '<?php echo getStaticUrl( 'CrazyCat\Base::js/text' ); ?>',
            utility: '<?php echo getStaticUrl( 'CrazyCat\Base::js/utility' ); ?>',
            translator: '<?php echo getStaticUrl( 'CrazyCat\Base::js/translator' ); ?>',
            editor: '<?php echo getStaticUrl( 'CrazyCat/Core/js/tinymce/tinymce.min' ); ?>'
        },
        shim: {
            editor: {
                exports: 'tinymce'
            }
        }
    } );

    require.config( {
        deps: [ 'translator' ],
        callback: function() {
            window.translationStorageName = '<?php echo md5( getBaseUrl() ); ?> :: crazycat-translations-' + window.languageCode;
            if ( !window.localStorage.getItem( window.translationStorageName ) ) {
                require( [ 'text!<?php echo getUrl( 'system/translate/source' ) ?>' ], function( translations ) {
                    window.localStorage.setItem( window.translationStorageName, translations );
                } );
            }
        }
    } );
    // ]]>
</script>