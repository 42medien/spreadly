<?php use_helper('YiidNumber'); ?>

<div class="widget widget-single widget-one-section">
	<header><section><?php echo $title ?></section></header>
	<section class="widget-data-section">
		<div class="large"><?php echo truncate_number($data['current_'.$type.'_count']) ?></div>
		<div class="bigger <?php echo upDownClass($data[$type.'_count_delta']) ?>">
		  <?php echo upDownArrow($data[$type.'_count_delta']) ?>&nbsp;
		  <?php echo absOrInfinity($data[$type.'_count_delta']) ?><small>&nbsp;%</small>
		</div>
		<?php if($range == 'today' || $range == 'yesterday'): ?>
		<div class="small" style="color: #707275;">
		  <?php echo truncate_number($data['current_pi_count']) ?> PIs&nbsp;
		  <?php echo upDownArrow($data['pi_count_delta']) ?>&nbsp;
		  <?php echo absOrInfinity($data['pi_count_delta']) ?><small>&nbsp;%</small>
		</div>		
		<div class="small" style="color: #707275;">
		  <?php echo absOrInfinity($data['current_conversion']) ?><small>&nbsp;%</small> Conversion
		</div>
		<?php endif; ?>
	</section>
	<footer>
	  Powered by @
		<?php
		  if (isset($powered_by)) {
		    echo $powered_by;
		  } else {
		    echo "Spreadly";
		  }
		?>
	</footer>
</div>
