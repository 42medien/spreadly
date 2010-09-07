<?php use_helper('YiidUrl', 'Avatar'); ?>
<?php if(count($pActivities) > 0) { ?>
	<?php foreach ($pActivities as $lActivity) { ?>
	<?php $lUser = UserTable::getInstance()->retrieveByPK($lActivity->getUId()); ?>
	  <li class="clearfix">
	    <div class="so_share_image left">
	      <?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>
	    </div>
	    <div class="so_share_spread left">
	      
	    </div>
	    <div class="so_share_information left">
	      <span class="user_share text_important"><?php echo $lUser->getFullname(); ?></span>
	      <span class="url"><?php echo __('%2 ago', array('%2' => $lActivity->getPublishingTime()), 'platform'); ?></span><br/>
	      <span class="url"><?php echo __('Shared with', null, 'platform'); ?></span>
	      <?php $lActivityCids = $lActivity->getCids(); ?>
	      <?php foreach($lActivityCids as $lCid) { ?>
	        <?php $lCommunityName = CommunityTable::getInstance()->retrieveByPk($lCid)->getName(); ?>
	        <?php $lCommunitySlug = CommunityTable::getInstance()->retrieveByPk($lCid)->getSlug(); ?>
	        <span class="icon_small_service_right icon_small_<?php echo $lCommunitySlug; ?>" title="<?php echo __('Shared with %1', array('%1' => $lCommunityName), 'platform'); ?>">&nbsp;</span>
	      <?php } ?>
	    </div>
	    <div class="right">
	      <?php if($lActivity->getScore() == 1) { ?>
	        <span class="thumb_up icon_detail_right">&nbsp;</span>
	      <?php } else {?>
	        <span class="thumb_down icon_detail_right">&nbsp;</span>
	      <?php } ?>
	    </div>
	  </li>
	<?php } ?>
<?php } else { ?>
  <li class="clearfix">
    <?php echo __("NO_ENTRIES"); ?>
  </li>
<?php } ?>

<li class="right right_shares_pager">
  <a href="#" id="item-stream-pager-link" class="pager_load_more" data-obj='{"action":"stream/get_item_detail_stream", "callback":"ItemDetailStream.show", "case":"all", "itemid":"<?php echo $pItemId; ?>", "page":"2"}'><?php echo __('Load more...', null, 'platform'); ?></a>
</li>