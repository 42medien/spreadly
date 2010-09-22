<div id="stream_right">
  <?php //include_partial('stream/item_detail', array('pObject' => $pObject, 'pActivities' => $pActivities)); ?>
  
  <div class="bg_light bd_normal_light">
    <div id="so_right_view" class="clearfix empty_right_view">
      <h4><?php echo __('Test Yiid immediately:'); ?></h4>
      
      <div id="preview">
	      <div id="yiid-widget">
	        <iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/like.php?<?php echo 'url='.rawurlencode('http://www.yiid.com').'&cult='.$sf_user->getCulture().'&type=like&color=%23000000&short='; ?>" style="overflow:hidden; width:270px; height: 23px; padding: 3px 0;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowTransparency="true"></iframe>
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
  
</div>