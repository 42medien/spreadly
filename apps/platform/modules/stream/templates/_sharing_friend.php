<li class="sharing_friend left">
  <div class="sharing_friend_outer user_<?php echo $lLikeType; ?>"></div>
  <div class="sharing_friend_inner">
    <?php echo image_tag('/img/test/yiid-logo.png', array('height' => '30px', 'width' => '30px')); ?>
  </div>
  <div class="clearfix user_hover_area" style="display: none;">
    <div class="user_hover_area_top">
      <div class="clearfix">
        <div class="sharing_user_image left">
          <?php echo image_tag('/img/test/yiid-logo.png', array('height' => '50px', 'width' => '50px')); ?>
        </div>
        <div class="sharing_user_info left">
          <h4>Matthias Affenkopf</h4>
          <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore...</p>
        </div>
      </div>
      <ul class="sharing_user_friends clearfix left">
        <?php for($i = 0; $i < 5; $i++) { ?>
          <li class="left"><?php echo image_tag('/img/test/yiid-logo.png', array('height' => '30px', 'width' => '30px')); ?></li>
        <?php } ?>
      </ul>
      <a href="/" class="sharing_user_link left">245 Friends</a>
    </div>
    <div class="user_hover_area_bottom"></div>
  </div>
</li>