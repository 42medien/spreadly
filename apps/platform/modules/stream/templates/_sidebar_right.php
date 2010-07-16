<div id="stream_right" class="bg_light bd_normal_light">
  
  <div id="so_right_view" class="clearfix">
    <div id="so_image" class="left"><?php echo image_tag('/img/global/yiid-logo.png', array('width' => 50)); ?></div>
    <div id="so_information" class="left">
      <h3>Giant solar-powered</h3>
      <h5><?php echo link_to('http://www.youtube.com/watch/pfefferle=affenkopf', 'http://www.youtube.com/watch/pfefferle=affenkopf', array('class' => 'url')); ?></h5>
      <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
    </div>
  </div>

  <div id="stream_right_top" class="clearfix">
    <?php include_partial('nav_shares'); ?>
  </div>
  
  <div id="stream_right_bottom">
    <ul class="shares">
    <?php for($i=0;$i<7;$i++) { ?>
      <li class="clearfix">
        <?php include_partial('item_shares'); ?>    
      </li>
    <?php } ?>
    </ul>
  </div>
  
</div>