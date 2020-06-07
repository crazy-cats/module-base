<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Message */
$messages = $this->getMessages();
?>
<div class="messages">
    <?php foreach ($messages as $messageType => $messageGroup) : ?>
        <div class="message-group <?= $messageType ?>">
            <ul>
                <?php foreach ($messageGroup as $message) : ?>
                    <li><?= $message ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>