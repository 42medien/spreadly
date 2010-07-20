<ul id="new_shares">
<?php foreach ($pSocialObjects as $lObject) { ?>
  <li class="clearfix stream_item" id="stream_item_<? echo $i; ?>">
    <?php include_partial('whats_hot_stream_item', array('pObject' => $lObject)); ?>
  </li>
<?php } ?>
</ul>