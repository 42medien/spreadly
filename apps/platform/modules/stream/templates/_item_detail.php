<?php use_helper('Text'); ?>

<?php if (isset($pObject) && $pObject != null) {?>
  <div class="bg_light bd_normal_light">
		<div id="so_right_view" class="clearfix">
		  <div>
		    <h3 title="<?php echo $pObject->getTitle(); ?>"><?php echo truncate_text($pObject->getTitle(), 30, '...'); ?></h3>
        <h5 title="<?php echo $pObject->getUrl(); ?>"><?php echo link_to(UrlUtils::getShortUrl($pObject->getUrl()), $pObject->getUrl(), array('class' => 'url')); ?></h5>
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
<?php } else { ?>
  <div class="bg_light bd_normal_light">
    <div id="so_right_view" class="clearfix empty_right_view">
      <h4><?php echo __('Test Yiid immediately:'); ?></h4>

      <div id="preview">
        <div id="yiid-widget">
          <iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/like.php?<?php echo 'url='.rawurlencode('http://www.yiid.com').'&cult='.$sf_user->getCulture().'&type=like&color=%23000000&short='; ?>" style="overflow:hidden; width:240px; height: 23px; padding: 3px 0;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowTransparency="true"></iframe>
        </div>
      </div>

      <h4><?php echo __('Further sites where you can test the Yiid button:'); ?></h4>
      <p><?php echo link_to('yasni.de', 'http://www.yasni.de', array('target' => '_blank')); ?></p>
      <p><?php echo link_to('blog.yiid.com', 'http://blog.yiid.com', array('target' => '_blank')); ?></p>
      <p><?php echo link_to('fragr.de', 'http://www.fragr.de', array('target' => '_blank')); ?></p>
      <p><?php echo link_to('mikestar.com', 'http://www.mikestar.com', array('target' => '_blank')); ?></p>
      <p><?php echo link_to('lumma.de', 'http://lumma.de', array('target' => '_blank')); ?></p>

      <h4><?php echo __('Own website?'); ?></h4>
      <p><?php echo __('If you have your own website or blog put the Yiid button on it:'); ?></p>
      <p><?php echo link_to('yiid.it', 'http://www.yiid.it'); ?></p>

    </div>
  </div>
<?php } ?>