<ul id="new_shares">
<?php foreach ($pActivities as $lObject) { ?>
  <li>new-stream</li>
  <li class="clearfix stream_item" id="stream_item_<?php echo $lObject->getId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo  $lObject->getId(); ?>", "css":"{\"itemid\":\"stream_item_<?php echo  $lObject->getId(); ?>\"}"}'>
    <?php include_partial('new_stream_item', array('pObject' => $lObject)); ?>
  </li>
  <?php } ?>
</ul>

<?php include_partial('stream/stream_pager'); ?>