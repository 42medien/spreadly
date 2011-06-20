<div class="widget widget-one-section widget-double">
	<header><section><?php echo $title ?> <?php echo ($range=='today'||$range=='yesterday') ? 'by hour' : 'by day' ?></section></header>
	<section class="widget-data-section chart-section">
		<div id="line-chart-<?php echo $type ?>">
			<?php include_partial('dashboard/chart_line_'.$type, array('data' => $data)) ?>
		</div>
	</section>
	<footer>
		Powered by @Spreadly
	</footer>
</div>
