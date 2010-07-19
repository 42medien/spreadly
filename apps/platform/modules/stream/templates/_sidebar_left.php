<?php use_helper('Text'); ?>

<div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">
  
  <div class="photo_big" id="stream_photo">
    <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 96, 'height' => 96)); ?>
  </div>
          
  <p class="filter_headline">All Networks</p>
  <ul class="normal_list clearfix" id="all_networks_list">
    <li class="service_filter_chosen">
      <a href="#" class="icon_service icon_facebook">facebook.com</a>
    </li>
    <li>
      <a href="#" class="icon_service icon_twitter">twitter.com</a>
    </li>
  </ul>
              
  <p class="filter_headline">Friends Active</p>
  <ul class="normal_list" id="friends_active_list">
    <li class="clearfix">      
      <a href="#" class="user_filter">
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Matthias Affenkopf', 18, '...'); ?>
      </a>
    </li>
    <li class="clearfix">    
      <a href="#" class="user_filter">
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Karina Mies', 18, '...'); ?>
      </a>
    </li>
    <li class="user_filter_chosen clearfix">    
      <a href="#" class="user_filter">
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Christian Weyand', 18, '...'); ?>
      </a>
    </li>
    <li class="clearfix">    
      <a href="#" class="user_filter">
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user left')); ?>
        <?php echo truncate_text('Dirk Müller', 18, '...'); ?>
      </a>
  </ul>

</div>