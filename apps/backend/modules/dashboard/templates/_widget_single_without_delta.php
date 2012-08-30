<?php use_helper('YiidNumber'); ?>

<div class="widget widget-single widget-one-section">
	<header><section><?php echo $title ?></section></header>
	<section class="widget-data-section">
		<div class="large"><?php echo truncate_number($data['current_'.$type.'_count']) ?></div>
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
