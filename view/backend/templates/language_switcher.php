<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\LanguageSwitcher */
$languages = $this->getLanguages();
$currentLangCode = $this->getCurrentLangCode();

$langOpts = [];
foreach ($languages as $language) {
    $langOpts[] = ['label' => $language['name'], 'value' => $language['code']];
}
?>
<div class="block block-language-switcher">
    <div class="block-content">
        <select>
            <?= selectOptionsHtml($langOpts, $currentLangCode) ?>
        </select>
        <script type="text/javascript">
            // <!CDATA[
            require(['jquery'], function ($) {
                var url = '<?= $this->getCurrentUrl(); ?>';
                $('.block-language-switcher select').on('change', function () {
                    window.location.href = url + (url.indexOf('?') === -1 ? '?' : '&') + 'lang=' + $(this).val();
                });
            });
            // ]]>
        </script>
    </div>
</div>