<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Index\Block\Message */
$messages = $this->getMessages();
?>
<div class="messages">
    <?php foreach ( $messages as $messageType => $messageGroup ) : ?>
        <div class="message-group <?php echo $messageType ?>">
            <ul>
                <?php foreach ( $messageGroup as $message ) : ?>
                    <li><?php echo $message ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>