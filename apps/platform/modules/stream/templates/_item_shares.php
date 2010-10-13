<?php use_helper('YiidUrl', 'Avatar'); ?>
<?php if(count($pActivities) > 0) { ?>
	<?php foreach ($pActivities as $lActivity) { ?>
	<?php $lUser = UserTable::getInstance()->retrieveByPK($lActivity->getUId()); ?>
	  <?php if ($lUser) { ?>
	  <li class="clearfix">
	    <div class="so_share_image left">
	      <?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>
	    </div>
	    <div class="so_share_information left">
	      <span class="user_share text_important"><?php echo $lUser->getFullname(); ?></span>
	      <span class="url"><?php echo __('%1 ago', array('%1' => $lActivity->getPublishingTime())); ?></span>
	      <?php $lOis = OnlineIdentityTable::getOisFromActivityOrderedByCommunity($lActivity->getRawValue()); ?>
        <?php if(count($lOis) > 0) { ?>
	        <br/>
		      <span class="url"><?php echo __('Shared with'); ?></span>
		      <?php foreach($lOis as $lOi) { ?>
	          <?php $lCommunity = $lOi->getCommunity(); ?>
		        <?php $lCommunityName = $lCommunity->getName(); ?>
		        <?php $lCommunitySlug = $lCommunity->getSlug(); ?>
		        <a href="<?php echo $lOi->getUrl();?>" class="no_link_display" target="_blank">
	            <span class="icon_small_service_right icon_small_<?php echo $lCommunitySlug; ?>" title="<?php echo __('Shared with %1', array('%1' => $lCommunityName)); ?>">&nbsp;</span>
	          </a>
		      <?php } ?>
		    <?php } ?>
	    </div>
	    <div class="right">
	      <?php if($lActivity->getScore() == 1) { ?>
	        <span class="thumb_up icon_small_use like-dislike">&nbsp;</span>
	      <?php } else {?>
	        <span class="thumb_down icon_small_use like-dislike">&nbsp;</span>
	      <?php } ?>
	    </div>
	  </li>
	  <?php } ?>
	<?php } ?>
<?php } else { ?>
  <li class="clearfix">
    <?php echo __('No entries'); ?>
  </li>
<?php } ?>

<li class="right right_shares_pager">
  <a href="#" id="item-stream-pager-link" class="pager_load_more" data-obj='{"action":"stream/get_item_detail_stream", "callback":"ItemDetailStream.show", "case":"all", "itemid":"<?php echo $pItemId; ?>", "page":"2"}'><?php echo __('Load more...', null); ?></a>
</li>