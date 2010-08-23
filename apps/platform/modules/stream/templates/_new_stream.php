<ul id="new_shares" class="stream_new">
<?php foreach ($pActivities as $lActivity) { ?>
  <?php $lObject = YiidActivityTable::retrieveSocialObjectByUrl($lActivity->getUrl()); ?>
  <li>new-stream</li>
  <li class="clearfix stream_item" id="stream_item_<?php echo $lActivity->getId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo  $lObject->getId(); ?>", "css":"{\"itemid\":\"stream_item_<?php echo  $lActivity->getId(); ?>\"}"}'>
    <?php include_partial('new_stream_item', array('pActivity' => $lActivity, 'pObject' => $lObject)); ?>
  </li>
  <?php } ?>
</ul>

<?php include_partial('stream/stream_pager'); ?>