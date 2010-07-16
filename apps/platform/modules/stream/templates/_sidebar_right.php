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
    <div id="stream_right_top7">
      <div id="stream_right_top1"></div>
      <div id="stream_right_top1b"><a href="#"	class="thumb_up_down icon_thumbs">&nbsp;</a></div>
      <div id="stream_right_top2"></div>
      <div id="stream_right_top3"><a href="#" class="thumb_up icon_thumb">&nbsp;</a></div>
      <div id="stream_right_top4"></div>
      <div id="stream_right_top5"><a href="#" class="thumb_down icon_thumb">&nbsp;</a></div>
      <div id="stream_right_top6"></div>
    </div>
  </div>
  
  <div id="stream_right_bottom">
    <ul id="shares">
    <?php for($i=0;$i<7;$i++) { ?>
      <li class="clearfix">
        <div class="so_share_image left"><?php echo image_tag('/img/global/yiid-logo.png', array('width' => 30)); ?></div>
        <div class="so_share_information left">
          <span class="icon_small_service icon_small_facebook">&nbsp;</span> 
          <?php echo link_to('Billy Brown', '@homepage', array('class' => 'text_important')); ?>
	        <span class="url">via Twitter 2 minutes ago</span>
	        <p class="so_comment">lorem ipsum pfefferle affenkopf</p>
        </div>
      </li>
    <?php } ?>
    </ul>
  </div>
  
</div>