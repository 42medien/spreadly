<?php if (isset($pObject)) {?>
  <div class="bg_light bd_normal_light">
		<div id="so_right_view" class="clearfix">
		  <div>
		    <h3><?php echo $pObject->getTitle(); ?></h3>
        <h5><?php echo link_to(UrlUtils::getShortUrl($pObject->getUrl()), $pObject->getUrl(), array('class' => 'url')); ?></h5>
		  </div>
		  <div id="so_detail_desc">
		    <img alt="<?php echo $pObject->getUrl(); ?>" width="100px" height="80px" src="http://communipedia.v2.websnapr.com/?url=<?php echo $pObject->getUrl(); ?>&sh=80&sw=100" class="left">
			  <span class="normal_text"><?php echo $pObject->getStmt(); ?></span>
			</div>
    </div>
		
		<div id="preview">
		  <div id="yiid-widget">
		    <iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/full.php?<?php echo 'url='.rawurlencode($pObject->getUrl()).'&cult='.$sf_user->getCulture().'&type=like&color=%23000000&short='; ?>" style="overflow:hidden; width:345px; height: 23px; padding: 3px 0;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowTransparency="true"></iframe>
		  </div>
		</div>

		<div id="stream_right_top" class="clearfix">
		  <?php include_partial('share_navigation', array('pObjectId' => $pObject->getId())); ?>
		</div>

		<div id="stream_right_bottom">
		  <ul class="shares clearfix" id="detail-stream">
		    <?php include_partial('item_shares', array('pActivities' => $pActivities, 'pItemId' => $pObject->getId())); ?>
		  </ul>
		</div>

  </div>
<?php } ?>