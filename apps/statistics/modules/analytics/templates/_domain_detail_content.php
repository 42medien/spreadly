<?php slot('content') ?>
<div id="line-chart-example">
<?php include_partial('analytics/chart_line_example'); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
  <?php include_component('analytics', 'top_url_overall_table', array("host" => $pHost->getHost())); ?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php slot('content') ?>
<div id="demo-pie-charts" class="clearfix">
	<div class="alignleft">
		<?php include_partial('analytics/chart_pie_example', array('pChartsettings' =>
					'{
								"width": 300,
								"height": 130,
								"margin": [ 0, 0, 10, 40],
								"plotsize": "40%",
								"bgcolor" : "#e1e1e1",
								"renderto":"demo-pie-charts"
						}'
		)); ?>
	</div>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php if(count($pDeals) > 0) { ?>
<?php slot('content') ?>
	<?php include_partial('analytics/deal_table', array('pDeals' => $pDeals)); ?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
<?php } ?>