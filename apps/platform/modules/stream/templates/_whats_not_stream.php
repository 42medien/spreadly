<ul id="new_shares">
<?php for($i=0;$i<15;$i++) { ?>
  <li class="clearfix stream_item" id="stream_item_<?php echo $i; ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<? echo $i; ?>", "css":"{\"itemid\":\"stream_item_<?php echo $i; ?>\"}"}'>
    <?php include_partial('whats_not_stream_item'); ?>
  </li>
<?php } ?>
</ul>