<div id="stream_left">
	<div id="stream_left_top" class="clearfix">
	  <?php include_partial('main_navigation'); ?>
	</div>

	<div id="stream_left_bottom" class="bg_light clearfix">
    <div id="stream_breadcrumb">
      <?php  include_partial('stream/breadcrumb', array('pUserName' => $pUsername, 'pComName' => $pComName))?>
    </div>

    <ul id="new_shares" class="hot_stream">
		  <?php include_partial('stream/whats_hot_stream', array('pSocialObjects' => $pSocialObjects)); ?>
		</ul>
	</div>
</div>