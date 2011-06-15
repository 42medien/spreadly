<div class="widget widget-single widget-one-section">
	<header><section><?php echo $title ?></section></header>
	<section class="widget-data-section chart-section">
		<div id="pie-chart-content">
							<?php include_partial('dashboard/chart_pie_example', array('pChartsettings' =>
								'{
									"width": 130,
									"height": 130,
									"margin": [0, 0, 10, 0],
									"plotsize": "75%",
									"bgcolor" : "#1e2021",
									"renderto" : "pie-chart-content"
									}',
									'pData' => '$pData')); ?>
		</div>
	</section>
	<footer>
		Powered by @Spreadly
	</footer>
</div>