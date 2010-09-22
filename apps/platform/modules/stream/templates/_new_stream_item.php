<?php use_helper('YiidUrl', 'Avatar'); ?>
<?php $pUser = UserTable::getInstance()->retrieveByPK($pActivity->getUId()); ?>
<div class="so_image left">
  <?php echo avatar_tag($pUser->getDefaultAvatar(), 48, array('alt' => $pUser->getFullname(), 'class' => '', 'rel' => '')); ?>
</div>

<div class="so_information left">
  <div class="green_arrow">

    <div class="clearfix">
	    <div class="green_top_middle left">
        <div class="green_top_left left"></div>
	      <div class="info_area clearfix">
	        <div class="left so_headline_left">
            <?php $lActivityCids = $pActivity->getCids(); ?>
			      <?php $lCommunityName = CommunityTable::getInstance()->retrieveByPk($lActivityCids[0])->getName(); ?>
			      <?php $lCommunitySlug = CommunityTable::getInstance()->retrieveByPk($lActivityCids[0])->getSlug(); ?>
			      <span class="icon_small_service icon_small_<?php echo $lCommunitySlug; ?> left" title="<?php echo __('Shared with %1', array('%1' => $lCommunityName)); ?>">&nbsp;</span>
	          <span class="user_share text_important left"><?php echo $pUser->getFullname(); ?></span>
	          <span class="url left">&nbsp;<?php echo __('%1 ago', array('%1' => $pActivity->getPublishingTime())); ?></span>
	        </div>
	        <div class="right so_headline_right">
            <span class="thumb_up icon_small_use like-dislike"><?php echo __('%1', array('%1' => $pObject->getLikeCount())); ?></span>
            <span class="thumb_down icon_small_use like-dislike"><?php echo __('%1', array('%1' => $pObject->getDislikeCount())); ?></span>
		      </div>
	      </div>
	    </div>
    </div>

    <div class="clearfix">
      <div class="green_middle_middle">
        <p class="so_comment">
          <?php echo ($pActivity->getScore() == 1 ?
            __('%1 <span class="text_important">likes</span> on %2<br/>', array('%1' => $pUser->getUsername(), '%2' => link_to($pActivity->getUrl(), $pActivity->getUrl(), array('class' => 'url')))) :
            __('%1 <span class="text_important">dislikes</span> on %2<br/>', array('%1' => $pUser->getUsername(), '%2' => link_to($pActivity->getUrl(), $pActivity->getUrl(), array('class' => 'url'))))); ?>
          <?php echo ($pObject->getTitle() ? $pObject->getTitle() : '').($pObject->getStmt() ? ' - '.$pObject->getStmt() : ''); ?>
        </p>
      </div>
    </div>

    <div class="clearfix">
      <div class="green_bottom_middle left">
        <div class="green_bottom_left left"></div>
      </div>
    </div>

  </div>
</div>