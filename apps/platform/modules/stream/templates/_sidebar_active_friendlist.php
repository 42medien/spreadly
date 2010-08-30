<?php use_helper('Text', 'Avatar'); ?>
    <?php foreach ($pFriends as $lFriend) { ?>
    <li class="clearfix" id="user-active-filter-<?php echo $lFriend->getId(); ?>">
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"StreamSubFilter.getAction", "callback":"Stream.show", "userid":"<?php echo $lFriend->getId(); ?>", "css": "{\"class\":\"normal_list\", \"id\":\"user-active-filter-<?php echo $lFriend->getId(); ?>\"}"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text($lFriend->getFullname(), 18, '...'); ?>
      </a>
    </li>
    <?php } ?>