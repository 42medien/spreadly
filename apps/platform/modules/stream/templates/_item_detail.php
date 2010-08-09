<?php if (isset($pObject)) {?>
<div id="so_right_view" class="clearfix">
  <div id="so_image" class="left"><?php echo image_tag('/img/global/yiid-logo.png', array('width' => 50)); ?></div>
  <div id="so_information" class="left">
    <h3><?php echo $pObject->getTitle(); ?></h3>
    <h5><?php echo link_to($pObject->getUrl(), $pObject->getUrl(), array('class' => 'url')); ?></h5>
    <p><?php echo $pObject->getStmt(); ?></p>
  </div>
</div>

  <div id="stream_right_top" class="clearfix">
    <?php include_partial('share_navigation', array('pObjectId' => $pObject->getId())); ?>
  </div>

  <div id="stream_right_bottom">
    <ul class="shares" id="detail-stream">
      <?php include_partial('item_shares', array('pActivities' => $pActivities)); ?>
    </ul>
  </div>
<?php } ?>