<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Core\Block\LanguageSwitcher */
$languages = $this->getLanguages();
$currentLangCode = $this->getCurrentLangCode();
$currentUrl = getCurrentUrl();
?>
<div class="block block-language-switcher">
    <div class="block-content">
        <ul>
            <?php
            foreach ( $languages as $language ) :
                $url = $currentUrl . ( strpos( $currentUrl, '?' ) === false ? '?' : '&' ) . 'lang=' . $language['code'];
                ?>
                <li>
                    <?php if ( $language['code'] == $currentLangCode ) : ?>
                        <a class="<?php echo $language['code'] ?>" href="<?php echo $url ?>"><span><?php echo $language['name'] ?></span></a>
                    <?php else : ?>
                        <span class="current"><?php echo $language['name'] ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>