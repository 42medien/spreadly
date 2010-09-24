<div id="stream_left">
	<div id="stream_left_top" class="clearfix">
	  <?php include_partial('main_navigation'); ?>
	</div>
	
	<div id="stream_left_bottom" class="bg_light clearfix">
    <div id="stream_breadcrumb">
      <?php echo __('You see:');?> <span id="breadcrumb_filter_friend" class="text_important"><?php echo __('All Friends'); ?></span> | <span id="breadcrumb_filter_community" class="text_important"><?php echo __('All Networks'); ?></span> 
    </div>
	
    <ul id="new_shares" class="hot_stream">
		  <?php include_partial('stream/whats_hot_stream', array('pSocialObjects' => $pSocialObjects)); ?>
		</ul>
	</div>
</div>