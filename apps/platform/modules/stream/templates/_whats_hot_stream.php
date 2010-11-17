<?php
if(count($pSocialObjects) > 0) {
  $i = 1;
  foreach ($pSocialObjects as $lObject) {
?>
<li class="clearfix stream_item" id="stream_item_<?php echo $lObject->getId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo $lObject->getId(); ?>", "css":"{\"itemid\":\"stream_item_<?php echo $lObject->getId(); ?>\"}"}'>
  <?php include_partial('whats_hot_stream_item', array('pObject' => $lObject)); ?>
</li>
<?php
    if ($i == 2) {
	    include_component('stream', 'inline_ad');
	  }

	  $i++;
	}

  include_partial('stream/stream_pager');
} else {
?>
<li class="clearfix stream_item" style="display:none;" id="stream_item_null" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"null", "css":"{\"itemid\":\"stream_item_null\"}"}'>
  <?php //include_partial('whats_hot_stream_item', array('pObject' => $lObject)); ?>
</li>
<?php
}

if (count($pSocialObjects) < 2) {
  include_component('stream', 'inline_ad');
}
?>