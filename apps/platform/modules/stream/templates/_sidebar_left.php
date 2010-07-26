<?php use_helper('Text'); ?>

<div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">

  <div class="photo_big" id="stream_photo">
    <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 96, 'height' => 96)); ?>
  </div>

  <p class="filter_headline"><?php echo __('All Networks'); ?></p>
  <ul class="normal_list clearfix" id="all_networks_list">
    <?php foreach ($pServices as $lService) { ?>
      <li id="com-filter-<?php echo $lService->getId(); ?>">
        <a href="/" class="icon_service icon_<?php echo strtolower($lService->getSlug()); ?> stream_filter" target="_blank" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "comid":"<?php echo $lService->getId(); ?>", "css":"{\"class\":\"normal_list\", \"id\":\"com-filter-<?php echo $lService->getId(); ?>\"}"}'><?php echo $lService->getName(); ?></a>
      </li>
    <?php } ?>
  </ul>

  <p class="filter_headline">Friends Active</p>
  <ul class="normal_list" id="friends_active_list">
    <li class="clearfix" id="user-filter-1">
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "userid":"1", "css": "{\"class\":\"normal_list\", \"id\":\"user-filter-1\"}"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Matthias Affenkopf', 18, '...'); ?>
      </a>
    </li>
    <li class="clearfix" id="user-filter-2">
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "userid":"2", "css": "{\"class\":\"normal_list\", \"id\":\"user-filter-2\"}"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Karina Mies', 18, '...'); ?>
      </a>
    </li>
    <li class="clearfix" id="user-filter-3">
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "userid":"3", "css": "{\"class\":\"normal_list\", \"id\":\"user-filter-3\"}"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Christian Weyand', 18, '...'); ?>
      </a>
    </li>
    <li class="clearfix" id="user-filter-4">
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"SubFilter.getAction", "callback":"Stream.show", "userid":"4", "css": "{\"class\":\"normal_list\", \"id\":\"user-filter-4\"}"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Dirk Müller', 18, '...'); ?>
      </a>
    </li>
  </ul>

</div>