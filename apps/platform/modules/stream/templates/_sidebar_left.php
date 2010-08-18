<?php use_helper('Text', 'Avatar'); ?>

<div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">

  <div class="photo_big" id="stream_photo">
    <?php echo avatar_tag($sf_user->getUser()->getMainAvatar(), '96x96'); ?>
  </div>

  <p class="filter_headline"><?php echo __('All Networks'); ?></p>
  <ul class="normal_list clearfix" id="all_networks_list">
    <li><a href="/" class="user_filter" target="_blank" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "comid":"0", "css":"{\"class\":\"normal_list\", \"id\":\"com-filter-0\"}"}'><?php echo __('All'); ?></a></li>
    <?php foreach ($pServices as $lService) { ?>
      <li id="com-filter-<?php echo $lService->getId(); ?>">
        <a href="/" class="icon_service icon_<?php echo strtolower($lService->getSlug()); ?> stream_filter" target="_blank" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "comid":"<?php echo $lService->getId(); ?>", "css":"{\"class\":\"normal_list\", \"id\":\"com-filter-<?php echo $lService->getId(); ?>\"}"}'><?php echo $lService->getName(); ?></a>
      </li>
    <?php } ?>
  </ul>

  <p class="filter_headline"><?php echo __('Friends Active', null, 'platform'); ?></p>
  <input type="text" id="input-friend-filter"/>
  <ul class="normal_list show" id="friends_active_list">
    <li>active</li>
    <?php include_partial('stream/sidebar_friendlist', array('pFriends'=>$pFriends));?>
  </ul>

  <ul class="normal_list" id="friends_all_list" style="display: none; height: 80px; overflow: scroll;">
    <li>all</li>
    <?php include_partial('stream/sidebar_friendlist', array('pFriends'=>$pFriends));?>
  </ul>
  Counter: <span id="friend-counter">500</span>
  <span><a href="/" id="all-friends-link"><?php echo __('SHOW_ALL_FRIENDS')?></a></span>
  
  <div class="center_area">
    <?php echo link_to(__('Abmelden'), '@auth_signout', array('class' => 'url')); ?>
  </div>
</div>