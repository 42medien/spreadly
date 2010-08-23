<?php use_helper('YiidUrl'); ?>
<?php $pUser = UserTable::getInstance()->retrieveByPK($pActivity->getUId()); ?>
<?php $lObject = YiidActivityTable::retrieveSocialObjectByUrl($pActivity->getUrl()); ?>
<div class="so_image left">
  <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 50)); ?>
</div>

<div class="so_information left">
  <div class="green_arrow">

    <div class="clearfix">
	    <div class="green_top_middle left">
        <div class="green_top_left left"></div>
	      <div class="info_area clearfix">
	        <div class="left so_headline_left">
	          <span class="icon_small_service icon_small_facebook left">&nbsp;</span>
	          <?php echo link_to_yiid($pUser->getFullname(), $pUser->getUsername(), array(), array('class' => 'user_share left')); ?>
	          <span class="url left">&nbsp;<?php echo __('via %1 %2 minutes ago', array('%1' => 'Twitter', '%2' => '2'), 'platform'); ?></span>
	        </div>
	        <div class="right so_headline_right">
            <a href="#" class="icon_like icon_small_use like-dislike"><?php echo __('%1', array('%1' => $lObject->getLikeCount()), 'platform'); ?></a>
            <a href="#" class="icon_dislike icon_small_use like-dislike"><?php echo __('%1', array('%1' => $lObject->getDislikeCount()), 'platform'); ?></a>
		      </div>
	      </div>
	    </div>
    </div>

    <div class="clearfix">
      <div class="green_middle_middle">
        <p class="so_comment">
          <?php echo ($pActivity->getScore() == 1 ? __('%1 likes on %2:', array('%1' => $pUser->getUsername(), '%2' => $pActivity->getUrl()), 'platform') : __('%1 dislikes on %2:', array('%1' => $pUser->getUsername(), '%2' => $pActivity->getUrl()), 'platform')); ?>
          <?php echo ($lObject->getTitle() ? $lObject->getTitle() : '').($lObject->getStmt() ? ' - '.$lObject->getStmt() : ''); ?>
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