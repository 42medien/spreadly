<?php use_helper('Text'); ?>

<div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">

  <div class="photo_big" id="stream_photo">
    <?php echo image_tag($sf_user->getUser()->getMainAvatar()->getAvatar(), array('width' => 96, 'height' => 96)); ?>
  </div>

  <p class="filter_headline"><?php echo __('All Networks'); ?></p>
  <ul class="normal_list clearfix" id="all_networks_list">
    <?php foreach ($pServices as $lService) { ?>
      <li id="com-filter-<?php echo $lService->getId(); ?>">
        <a href="/" class="icon_service icon_<?php echo strtolower($lService->getSlug()); ?> stream_filter" target="_blank" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "comid":"<?php echo $lService->getId(); ?>", "css":"{\"class\":\"normal_list\", \"id\":\"com-filter-<?php echo $lService->getId(); ?>\"}"}'><?php echo $lService->getName(); ?></a>
      </li>
    <?php } ?>
  </ul>

  <p class="filter_headline"><?php echo __('Friends Active', null, 'platform'); ?></p>
  <ul class="normal_list" id="friends_active_list">
    <?php foreach ($pFriends as $lFriend) { ?>
    <li class="clearfix" id="user-filter-<?php echo $lFriend->getId(); ?>">
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "userid":"<?php echo $lFriend->getId(); ?>", "css": "{\"class\":\"normal_list\", \"id\":\"user-filter-<?php echo $lFriend->getId(); ?>\"}"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text($lFriend->getFullname(), 18, '...'); ?>
      </a>
    </li>
    <?php } ?>
  </ul>

</div>