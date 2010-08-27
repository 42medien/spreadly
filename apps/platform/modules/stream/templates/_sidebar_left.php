<?php use_helper('Text', 'Avatar'); ?>
<?php $lUser = $sf_user->getUser(); ?>
<div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">

  <div class="photo_big" id="stream_photo">
    <?php echo avatar_tag($lUser->getDefaultAvatar(), 140, array('alt' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>
  </div>
<!-- filter_headline_communities_active  -->
  <p class="filter_headline_communities filter_headline_communities_active clearfix">
    <a href="/" class="left user_filter stream_filter reset-filter" target="_blank" data-obj='{"action":"StreamSubFilter.getAction", "callback":"Stream.show", "css":"{\"class\":\"normal_list\", \"id\":\"com-filter-0\"}"}'>
      <?php echo __('All Networks'); ?>
    </a>
    <span class="right filter_chosen_icon">&nbsp;</span>
  </p>
  <ul class="normal_list clearfix" id="all_networks_list">
    <?php foreach ($pServices as $lService) { ?>
      <li id="com-filter-<?php echo $lService->getId(); ?>">
        <a href="/" class="icon_service icon_<?php echo strtolower($lService->getSlug()); ?> stream_filter" target="_blank" data-obj='{"action":"StreamSubFilter.getAction", "callback":"Stream.show", "comid":"<?php echo $lService->getId(); ?>", "css":"{\"class\":\"normal_list\", \"id\":\"com-filter-<?php echo $lService->getId(); ?>\"}"}'><?php echo $lService->getName(); ?></a>
      </li>
    <?php } ?>
  </ul>
<!-- filter_headline_friends_active  -->
  <p class="filter_headline_friends clearfix" id="active_friends_headline">
    <a href="/" class="left user_filter stream_filter reset-filter" data-obj='{"action":"StreamSubFilter.getAction", "callback":"Stream.show", "css": "{\"class\":\"normal_list\", \"id\":\"user-filter-0\"}"}'>
      <?php echo __('ACTIVE_FRIENDS', null, 'platform'); ?>
    </a>
    <span class="right filter_chosen_icon" style="display:none;">&nbsp;</span>
  </p>

  <div class="center_area filter_counter_area" id="friend-filter-area">
    <span><?php echo __('Sort by: ', null, 'platform'); ?></span>
    <!-- friend_filter_link_active -->
    <span><a href="/" id="friends_active" class="friend-filter-link"><?php echo __('Active', null, 'platform')?></a> | </span>
    <span><a href="/" id="friends_all" class="friend-filter-link"><?php echo __('A-Z', null, 'platform')?></a></span>
  </div>
  <div class="center_area search_field_area">
    <form name="friendlistfilterform" autocomplete="off" >
      <input type="text" id="input-friend-filter" value="<?php echo __('Type name to filter...', null, 'platform'); ?>" />
    </form>
  </div>
  <ul class="normal_list show friend-filter-list" id="friends_active_list">
    <?php include_partial('stream/sidebar_friendlist', array('pFriends'=>$pFriends));?>
  </ul>

  <ul class="normal_list friend-filter-list" id="friends_all_list">
    <?php include_partial('stream/sidebar_friendlist', array('pFriends'=>$pAllFriends));?>
  </ul>

  <ul class="normal_list friend-filter-list" id="friends_search_results">
    <?php include_partial('stream/sidebar_friendlist', array('pFriends'=>array()));?>
  </ul>

  <div class="center_area filter_counter_area" id="friend-counter-box">
    <span id="friend-counter"><?php echo $pFriendsCount; ?></span> <?php echo __('Results', null, 'platform'); ?>
  </div>

</div>