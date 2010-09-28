<?php use_helper('Text', 'Avatar'); ?>
    <?php foreach ($pFriends as $lFriend) { ?>
    <li class="clearfix" id="user-active-filter-<?php echo $lFriend->getId(); ?>">
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"StreamSubFilter.getAction", "callback":"Stream.show", "userid":"<?php echo $lFriend->getId(); ?>", "css": "{\"class\":\"normal_list\", \"id\":\"user-active-filter-<?php echo $lFriend->getId(); ?>\"}"}'>
        <?php echo avatar_tag($lFriend->getDefaultAvatar(), 16, array('alt' => $lFriend->getFullname(), 'class' => '', 'rel' => '')); ?>
        <span><?php echo truncate_text($lFriend->getFullname(), 22, '...'); ?></span>
      </a>
    </li>
    <?php } ?>