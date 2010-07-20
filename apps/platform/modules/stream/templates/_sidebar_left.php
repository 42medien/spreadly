<?php use_helper('Text'); ?>

<div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">
  
  <div class="photo_big" id="stream_photo">
    <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 96, 'height' => 96)); ?>
  </div>
          
  <p class="filter_headline">All Networks</p>
  <ul class="normal_list clearfix" id="all_networks_list">
    <li class="filter_chosen" id="com-filter-1">
      <a href="/" class="icon_service icon_facebook stream_filter" target="_blank" data-obj='{"action":"StreamFilter.getAction", "callback":"Stream.show", "comid":"1", "cssid":"com-filter-1"}'>facebook.com</a>
    </li>
    <li id="com-filter-2">
      <a href="/" class="icon_service icon_twitter stream_filter" target="_blank" data-obj='{"action":"StreamFilter.getAction", "callback":"Stream.show", "comid":"2", "cssid":"com-filter-2"}'>twitter.com</a>
    </li>
  </ul>
              
  <p class="filter_headline">Friends Active</p>
  <ul class="normal_list" id="friends_active_list">
    <li class="clearfix">      
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"StreamFilter.getAction", "callback":"Stream.show", "userid":"1"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Matthias Affenkopf', 18, '...'); ?>
      </a>
    </li>
    <li class="clearfix">    
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"StreamFilter.getAction", "callback":"Stream.show", "userid":"2"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Karina Mies', 18, '...'); ?>
      </a>
    </li>
    <li class="filter_chosen clearfix">    
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"StreamFilter.getAction", "callback":"Stream.show", "userid":"3"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Christian Weyand', 18, '...'); ?>
      </a>
    </li>
    <li class="clearfix">    
      <a href="/" class="user_filter stream_filter" data-obj='{"action":"StreamFilter.getAction", "callback":"Stream.show", "userid":"4"}'>
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Dirk Müller', 18, '...'); ?>
      </a>
    </li>
  </ul>

</div>