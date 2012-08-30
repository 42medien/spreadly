<div class="graybox-wrapper<?php if (isset($pClass)) { echo ' '.$pClass; } ?>">
  <div class="grboxtop"><span></span></div>
  <div class="grboxmid">
  	<div class="grboxmid-content">
  		<div class="graybox clearfix">
  	    <?php include_slot('content'); ?>
  		</div>
  	</div>
  </div>
  <div class="grboxbot"><span></span></div>
</div>