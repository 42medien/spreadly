<?php slot('content') ?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;
	<?php echo link_to($pDomain->getUrl(), 'analytics/domain_statistics?domainid='.$pDomain->getId()); ?>&nbsp;
	<?php echo __('Overview'); ?>
</div>

<div>
	<label id="websel" for="host_id">
		<select class="custom-select" id="filter_period" name="filter_period">
			<option value="today"><?php echo __('Today'); ?></option>
			<option value="yesterday" selected="selected"><?php echo __('Yesterday'); ?></option>
			<option value="lastweek"><?php echo __('Last week'); ?></option>
			<option value="lastmonth"><?php echo __('Last month'); ?></option>
			<option value="all"><?php echo __('All'); ?></option>
	  </select>
	</label>
	<?php echo link_to('Other period', '/', array('id' => 'select-period-link')); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
<div id="line-chart-example">
<?php include_partial('analytics/chart_line_example'); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
  <?php include_partial('url_table', array("pHostId" => null, "pFrom" => null, "pTo" => null, "pData" => $pTopActivitiesData)) ?>
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
								"bgcolor" : "#e1e1e1"
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