<?php use_helper('Text', 'Avatar'); ?>
    <?php //foreach ($pFriends as $lFriend) { ?>
        <?php echo avatar_tag($lFriend->getDefaultAvatar(), 16, array('alt' => $lFriend->getFullname(), 'class' => '', 'rel' => '')); ?>
    <?php //} ?>