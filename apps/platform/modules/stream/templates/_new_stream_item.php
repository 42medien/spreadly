<?php use_helper('YiidUrl', 'Avatar', 'Text'); ?>

<?php $pUser = UserTable::getInstance()->retrieveByPK($pActivity->getUId()); ?>
<div class="so_image left">
  <div class="sharing_friend_outer left">
    <div class="user_<?php echo $pActivity->getScore() == '-1' ? 'dislike' : 'like'; ?>"></div>
  </div>
  <div class="sharing_friend_inner">
    <?php echo avatar_tag($pUser->getDefaultAvatar(), 48, array('alt' => $pUser->getFullname(), 'class' => '', 'rel' => '')); ?>
  </div>
</div>

<div class="so_information left">
  <div class="green_arrow">

    <div class="clearfix">
	    <div class="green_top_middle left">
        <div class="green_top_left left"></div>
	      <div class="info_area clearfix">
	        <div class="left so_headline_left">
	          <span class="user_share text_important left"><?php echo $pUser->getFullname(); ?></span>
	          <span class="url left">&nbsp;<?php echo __('%1 ago', array('%1' => $pActivity->getPublishingTime())); ?></span>
	        </div>
	        <div class="right so_headline_right">
            <span class="thumb_up icon_small_use like-dislike"><?php echo $pObject->getLikeCount(); ?></span>
            <span class="thumb_down icon_small_use like-dislike"><?php echo $pObject->getDislikeCount(); ?></span>
		      </div>
	      </div>
	    </div>
    </div>

    <div class="clearfix">
      <div class="green_middle_middle">
          <p class="so_comment text_important"><?php echo truncate_text($pObject->getTitle(), 35, '...'); ?></p>
          <p class="so_comment" title="<?php echo $pActivity->getUrl(); ?>"><?php echo link_to(UrlUtils::getShortUrl($pActivity->getUrl()), url_for($pActivity->getUrl(), true), array('class' => 'url')); ?></p>
          <p class="so_comment main_text"><?php echo truncate_text($pObject->getStmt(), 100, '...'); ?></p>
      </div>
    </div>

    <div class="clearfix">
      <div class="green_bottom_middle left">
        <div class="green_bottom_left left"></div>
      </div>
    </div>

  </div>
</div>