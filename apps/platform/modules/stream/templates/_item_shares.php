<?php use_helper('YiidUrl', 'Avatar'); ?>
<?php foreach ($pActivities as $lActivity) { ?>
<?php $lUser = UserTable::getInstance()->retrieveByPK($lActivity->getUId()); ?>
  <li class="clearfix">
    <div class="so_share_image left">
      <?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>
    </div>
    <div class="so_share_spread left">
      <?php $lActivityCids = $lActivity->getCids(); ?>
      <?php foreach($lActivityCids as $lCid) { ?>
        <?php $lCommunityName = CommunityTable::getInstance()->retrieveByPk($lCid)->getSlug(); ?>
        <span class="icon_small_service_right icon_small_<?php echo $lCommunityName; ?>">&nbsp;</span><br/>
      <?php } ?>
    </div>
    <div class="so_share_information left">
      <?php echo link_to_yiid($lUser->getFullname(), $lUser->getUsername(), null, array('class' => 'user_share')); ?><br/>
      <span class="url"><?php echo __('via %1 %2 minutes ago', array('%1' => 'Twitter', '%2' => '2'), 'platform'); ?></span>
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


<div class="right right_shares_pager">
  <a href="#" id="item-stream-pager-link" class="pager_load_more" data-obj='{"action":"stream/get_item_detail_stream", "callback":"ItemDetailStream.show", "case":"all", "itemid":"<?php echo $pItemId; ?>", "page":"2"}'><?php echo __('Load more...', null, 'platform'); ?></a>
</div>