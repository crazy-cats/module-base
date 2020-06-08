<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Head */
?>
<script type="text/javascript" src="<?= $this->getStaticUrl('CrazyCat\Base::js/require.js'); ?>"></script>
<script type="text/javascript">
    // <![CDATA[
    window.languageCode = '<?= $this->getLangCode(); ?>';
    window.localStoragePrefix = '<?= $this->getLocalStoragePrefix(); ?>';

    require.config({
        baseUrl: '<?= $this->getStaticUrl(''); ?>',
        waitSeconds: 0,
        paths: {
            jquery: '<?= $this->getStaticUrl('CrazyCat\Base::js/jquery'); ?>',
            text: '<?= $this->getStaticUrl('CrazyCat\Base::js/text'); ?>',
            utility: '<?= $this->getStaticUrl('CrazyCat\Base::js/utility'); ?>',
            translator: '<?= $this->getStaticUrl('CrazyCat\Base::js/translator'); ?>',
            editor: '<?= $this->getStaticUrl('CrazyCat/Base/js/tinymce/tinymce.min'); ?>'
        },
        shim: {
            editor: {
                exports: 'tinymce'
            }
        }
    });

    require.config({
        deps: ['translator'],
        callback: function () {
            window.translationStorageName = '<?= md5($this->getBaseUrl()); ?> :: crazycat-translations-'
                + window.languageCode;
            if (!window.localStorage.getItem(window.translationStorageName)) {
                require(['text!<?= getUrl('system/translate/source') ?>'], function (translations) {
                    window.localStorage.setItem(window.translationStorageName, translations);
                });
            }
        }
    });
    // ]]>
</script>