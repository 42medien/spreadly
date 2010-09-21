<div id="stream_left">
  <?php if(count($pSocialObjects)) { ?>
	  <div id="stream_left_top" class="clearfix">
	    <?php include_partial('main_navigation'); ?>
	  </div>
	
	  <div id="stream_left_bottom" class="bg_light clearfix">
		    
		  <ul id="new_shares" class="hot_stream">
		    <?php include_partial('stream/whats_hot_stream', array('pSocialObjects' => $pSocialObjects)); ?>
		  </ul>
	  </div>
      
  <?php } else { ?>
    <div id="stream_left_bottom" class="bg_light clearfix">
	    <ul id="new_shares" class="hot_stream">  
	      <?php include_partial('stream/empty_stream'); ?>
	    </ul>
	  </div>
    
  <?php } ?>
</div>