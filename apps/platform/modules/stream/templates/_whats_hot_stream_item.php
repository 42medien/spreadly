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
	      <p class="text_important"><?php echo $pObject->getTitle(); ?></p>
	      <p class="url"><?php echo link_to($pObject->getUrl(), url_for($pObject->getUrl(), true)); ?></p>
	      <p><?php echo $pObject->getStmt(); ?></p>
	    </div>
	  </div>
	  <div class="right preview_information">
      <?php echo image_tag('/img/test/map_preview.png'); ?>
	  </div>
	</div>

	<!-----------  Das folgende div muss auf style="display:none;" gesetzt und nur bei hover angezeigt werden ------------------------------>
	<div class="actions clearfix">
    <ul class="sharing_friends left">

      <?php include_partial('sharing_friend', array('lLikeType' => 'like')); ?>
      <?php include_partial('sharing_friend', array('lLikeType' => 'dislike')); ?>
      <?php include_partial('sharing_friend', array('lLikeType' => 'like')); ?>
      <?php include_partial('sharing_friend', array('lLikeType' => 'dislike')); ?>
      <?php include_partial('sharing_friend', array('lLikeType' => 'like')); ?>

    </ul>

	  <div class="action_content right">
	    <a href="#" class="icon_comment icon_small_use text_action">comment</a>
	    <a href="#" class="icon_favorite icon_small_use text_action">favorite</a>
	    <a href="#" class="icon_hide icon_small_use text_action">hide</a>
	  </div>
	</div>
	<!-----------  Das vorige div muss auf style="display:none;" gesetzt und nur bei hover angezeigt werden ------------------------------>
</div>