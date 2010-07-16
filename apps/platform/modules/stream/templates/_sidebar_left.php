<?php use_helper('Text'); ?>

<div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">
  
  <div class="photo_big" id="stream_photo">
    <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 96, 'height' => 96)); ?>
  </div>
          
  <p class="filter_headline">All Networks</p>
  <ul class="normal_list" id="all_networks_list">
    <li><a href="#" class="icon_service icon_facebook">facebook.com</a></li>
    <li><a href="#" class="icon_service icon_twitter">twitter.com</a></li>
  </ul>
              
  <p class="filter_headline">Friends Active</p>
  <ul class="normal_list" id="friends_active_list">
  <?php for($i=0;$i<=2;$i++) { ?>
    <li class="clearfix">      
      <a href="#">
        <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user')); ?>
        <span class="text_user"><?php echo truncate_text('Matthias Affenkopf', 18, '...'); ?></span>
      </a>
    </li>
  <?php } ?>
  </ul>

</div>