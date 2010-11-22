<?php if(count($pActivities) > 0) {?>
<!-- <ul id="new_shares" class="stream_new"> -->
<?php $i = 1; ?>
<?php foreach ($pActivities as $lActivity) { ?>
  <?php $lObject = YiidActivityTable::retrieveSocialObjectByAliasUrl($lActivity->getUrl()); ?>
    <?php if ($lObject) { ?>
    <li class="clearfix stream_item" id="stream_item_<?php echo $lActivity->getId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo  $lObject->getId(); ?>", "css":"{\"itemid\":\"stream_item_<?php echo  $lActivity->getId(); ?>\"}"}'>
      <?php include_partial('new_stream_item', array('pActivity' => $lActivity, 'pObject' => $lObject)); ?>
    </li>
    <?php } ?>
    <?php
    if ($i == 2) {
      //include_component('stream', 'inline_ad_new');
    }

    $i++;
    ?>
  <?php } ?>
  <?php include_partial('stream/stream_pager'); ?>
<?php } else { ?>
  <li class="clearfix stream_item" style="display:none;" id="stream_item_null" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"null", "css":"{\"itemid\":\"stream_item_null\"}"}'>
    <?php //include_partial('whats_hot_stream_item', array('pObject' => $lObject)); ?>
  </li>
<?php } ?>

<?php
if (count($pSocialObjects) < 2) {
  //include_component('stream', 'inline_ad_new');
}
?>
<!-- </ul> -->