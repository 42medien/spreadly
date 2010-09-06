<div class="whats_hot_stream_item">
	<div class="clearfix">
    <div class="whats_hot_stream_icon left">
      <span class="stream_icon stream_icon_location">&nbsp;</span>
    </div>
	  <div class="left whats_hot_stream_head_left">
      <div class="clearfix">
        <div class="left so_headline_left">
          <?php echo image_tag('http://getfavicon.appspot.com/'.$pObject->getUrl(), array('class' => 'icon_small_service left')); ?>
          <span class="url left"><?php echo __('via %1 %2 ago', array('%1' => $pObject->getCommunityNames(), '%2' => $pObject->getPublishingTime()), 'platform'); ?></span>
        </div>
        <div class="right so_headline_right">
          <span class="thumb_up icon_small_use like-dislike"><?php echo __('%1', array('%1' => $pObject->getLikeCount()), 'platform'); ?></span>
          <span class="thumb_down icon_small_use like-dislike"><?php echo __('%1', array('%1' => $pObject->getDislikeCount()), 'platform'); ?></span>
        </div>
      </div>
      <div class="clearfix whats_hot_info_area">
	      <p class="text_important"><?php echo $pObject->getTitle(); ?></p>
        <p><?php echo link_to($pObject->getUrl(), url_for($pObject->getUrl(), true), array('class' => 'url')); ?></p>
        <p class="main_text"><?php echo $pObject->getStmt(); ?></p>
	    </div>
	  </div>
	  <div class="right preview_information">
	  
	  </div>
	</div>
</div>