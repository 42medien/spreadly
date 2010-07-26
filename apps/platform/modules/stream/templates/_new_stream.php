<ul id="new_shares">
  <?php for($i=0;$i<=10;$i++) { ?>
  <li class="clearfix stream_item" id="stream_item_<?php echo $i ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo $i ?>", "css":"{\"itemid\":\"stream_item_<?php echo $i ?>\"}"}'>
    <?php include_partial('new_stream_item'); ?>
  </li>
  <?php } ?>
</ul>

<!-- 
<ul id="new_shares">
<?php foreach($lShares as $lShare) { ?>
  <li class="clearfix stream_item" id="stream_item_<?php echo $lShare->getId(); ?>" data-obj='{"action":"StreamItem.getDetailAction", "callback":"ItemDetail.show", "itemid":"<?php echo $i ?>", "css":"{\"itemid\":\"stream_item_<?php echo $i ?>\"}"}'>>
    <?php include_partial('new_stream_item', array($lShare)); ?>
  </li>
<?php } ?>
</ul> 
 -->

<div class="clearfix main_stream_pager">
  <a href="/" class="pager_load_more">Load more...</a>
</div>