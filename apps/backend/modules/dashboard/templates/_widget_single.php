<div class="widget widget-single widget-one-section">
	<header><section><?php echo $title ?></section></header>
	<section class="widget-data-section">
		<div class="large"><?php echo $data['current_'.$type.'_count'] ?></div>
		<div class="bigger <?php echo upDownClass($data[$type.'_count_delta']) ?>">
		  <?php echo upDownArrow($data[$type.'_count_delta']) ?>&nbsp;
		  <?php echo absOrInfinity($data[$type.'_count_delta']) ?><small>&nbsp;%</small>
		</div>
	</section>
	<footer>
		Powered by @Spreadly
	</footer>
</div>
