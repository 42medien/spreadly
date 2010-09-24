<?php use_helper('Text'); ?>

<div class="whats_hot_stream_item">
	<div class="clearfix">
    <div class="whats_hot_stream_icon left">
      <span class="stream_icon stream_icon_location">&nbsp;</span>
    </div>
	  <div class="left whats_hot_stream_head_left">
      <div class="clearfix">
        <div class="left so_headline_left">
          <?php echo image_tag('http://getfavicon.appspot.com/'.$pObject->getUrl(), array('class' => 'icon_small_service left', 'width' => '16px', 'height' => '16px')); ?>
          <span class="url left"><?php echo __('%1 ago', array('%1' => $pObject->getPublishingTime())); ?></span>
        </div>
        <div class="right so_headline_right">
          <span class="thumb_up icon_small_use like-dislike"><?php echo $pObject->getLikeCount(); ?></span>
          <span class="thumb_down icon_small_use like-dislike"><?php echo $pObject->getDislikeCount(); ?></span>
        </div>
      </div>
      <div class="clearfix whats_hot_info_area">
	      <p class="text_important"><?php echo truncate_text($pObject->getTitle(), 35, '...'); ?></p>
        <p title="<?php echo $pObject->getUrl(); ?>"><?php echo link_to(UrlUtils::getShortUrl($pObject->getUrl()), url_for($pObject->getUrl(), true), array('class' => 'url')); ?></p>
        <p class="main_text"><?php echo truncate_text($pObject->getStmt(), 100, '...'); ?></p>
	    </div>
	  </div>
	  <div class="right preview_information">
      <img alt="<?php echo $pObject->getUrl(); ?>" width="100px" height="80px"  src="http://communipedia.v2.websnapr.com/?url=<?php echo $pObject->getUrl(); ?>&sh=80&sw=100">
	  </div>
	</div>
</div>