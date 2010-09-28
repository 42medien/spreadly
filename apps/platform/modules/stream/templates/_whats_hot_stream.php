<?php if(count($pSocialObjects) > 0) {?>
	<?php foreach ($pSocialObjects as $lObject) { ?>
	  <li class="clearfix stream_item" id="stream_item_<? echo $lObject->getId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo $lObject->getId(); ?>", "css":"{\"itemid\":\"stream_item_<?php echo $lObject->getId(); ?>\"}"}'>
	    <?php include_partial('whats_hot_stream_item', array('pObject' => $lObject)); ?>
	  </li>
	<?php } ?>
  <?php include_partial('stream/stream_pager'); ?>
<?php } else { ?>
  <li class="clearfix stream_item" style="display:none;" id="stream_item_null" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"null", "css":"{\"itemid\":\"stream_item_null\"}"}'>
    <?php //include_partial('whats_hot_stream_item', array('pObject' => $lObject)); ?>
  </li>
<?php } ?>