<?php use_helper('YiidUrl'); ?>
<?php foreach ($pActivities as $lActivity) { ?>
<?php $lUser = UserTable::getInstance()->retrieveByPK($lActivity->getUId()); ?>
  <li class="clearfix">
    <div class="so_share_image left"><?php echo image_tag('/img/global/yiid-logo.png', array('width' => 30)); ?></div>
    <div class="so_share_information left">
      <span class="icon_small_service icon_small_facebook">&nbsp;</span>
      <?php echo link_to_yiid($lUser->getFullname(), $lUser->getUsername(), null, array('class' => 'user_share')); ?>
      <span class="url"><?php echo __('via %1 %2 minutes ago', array('%1' => 'Twitter', '%2' => '2'), 'platform'); ?></span>
    </div>
  </li>
<?php  }?>


<div class="right right_shares_pager">
  <a href="#" id="item-stream-pager-link" class="pager_load_more" data-obj='{"action":"stream/get_item_detail_stream", "callback":"ItemDetailStream.show", "case":"all", "itemid":"<?php echo $pItemId; ?>", "page":"1"}'><?php echo __('Load more...', null, 'platform'); ?></a>
</div>

<div class="clearfix">&nbsp;</div>