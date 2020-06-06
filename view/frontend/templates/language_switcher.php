<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\LanguageSwitcher */
$languages = $this->getLanguages();
$currentLangCode = $this->getCurrentLangCode();
$currentUrl = $this->getCurrentUrl();
?>
<div class="block block-language-switcher">
    <div class="block-content">
        <ul>
            <?php
            foreach ($languages as $language) :
                $url = $currentUrl . (strpos($currentUrl, '?') === false ? '?' : '&') . 'lang=' . $language['code'];
                ?>
                <li>
                    <?php if ($language['code'] == $currentLangCode) : ?>
                        <a class="<?= $language['code'] ?>"
                           href="<?= $url ?>"><span><?= $language['name'] ?></span></a>
                    <?php else : ?>
                        <span class="current"><?= $language['name'] ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>