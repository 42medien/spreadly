<div class="whats_hot_stream_item">
	<div class="clearfix">
    <div class="whats_hot_stream_icon left">
      <span class="stream_icon stream_icon_location">&nbsp;</span>
    </div>
	  <div class="left whats_hot_stream_head_left">
      <div class="clearfix">
        <div class="left so_headline_left">
          <span class="icon_small_service icon_small_facebook left">&nbsp;</span>
          <span class="url left">via Twitter 2 minutes ago</span>
        </div>
        <div class="right so_headline_right">
          <a href="#" class="icon_like icon_small_use like-dislike"><?php echo $pObject->getLikeCount(); ?>  like</a>
          <a href="#" class="icon_dislike icon_small_use like-dislike"><?php echo $pObject->getDislikeCount(); ?> dislike</a>
        </div>
      </div>
      <div class="clearfix whats_hot_info_area">
	      <p class="text_important">Berlin, Germany</p>
	      <p class="url">type / 52° 30' 35.59° N 13° 22' 25.76° E</p>
	      <p>Intensive trials are under way as the world's largest solar-powered yacht...</p>
	    </div>
	  </div>
	  <div class="right preview_information">
      <?php echo image_tag('/img/test/map_preview.png'); ?>
	  </div>
	</div>

	<!-----------  Das folgende div muss auf style="display:none;" gesetzt und nur bei hover angezeigt werden ------------------------------>
	<div class="actions clearfix">
    <ul class="sharing_friends left">
      
      <?php for($j=0;$j<5;$j++) { ?>
	      <li class="sharing_friend left">
		      <div class="sharing_friend_outer">&nbsp;</div>
		      <div class="sharing_friend_inner">
		        <?php echo image_tag('/img/test/yiid-logo.png', array('height' => '30px', 'width' => '30px')); ?>
		      </div>
          <div class="clearfix user_hover_area">
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
		  <?php } ?>
	    
    </ul>
	
	  <div class="action_content right">
	    <a href="#" class="icon_comment icon_small_use text_action">comment</a>
	    <a href="#" class="icon_favorite icon_small_use text_action">favorite</a>
	    <a href="#" class="icon_hide icon_small_use text_action">hide</a>
	  </div>
	</div>
	<!-----------  Das vorige div muss auf style="display:none;" gesetzt und nur bei hover angezeigt werden ------------------------------>
</div>