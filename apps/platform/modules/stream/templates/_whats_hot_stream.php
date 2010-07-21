<ul id="new_shares">
<?php foreach ($pSocialObjects as $lObject) { ?>
  <li class="clearfix stream_item" id="stream_item_<? echo $lObject->getId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo $lObject->getId(); ?>", "css":"{\"itemid\":\"stream_item_<?php echo $lObject->getId(); ?>\"}"}'>
    <?php include_partial('whats_hot_stream_item', array('pObject' => $lObject)); ?>
  </li>
<?php } ?>
</ul>

<div class="clearfix main_stream_pager">
  <a href="/" class="pager_load_more">Load more...</a>
</div>