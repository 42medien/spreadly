<?php slot('content') ?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;&gt;&nbsp;
	<?php echo link_to($pDomain->getUrl(), 'analytics/domain_statistics?domainid='.$pDomain->getId()); ?>&nbsp;&gt;&nbsp;
	<?php echo __('Overview'); ?>
</div>

<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$pDomain->getId(), array('class' => 'alignright'));?>
<h2><?php echo __('Overview for domain %domain%', array('%domain%' => $pDomain->getUrl()));?></h2>
<div class="clearfix" id="stat-infos">
	<div class="alignleft stat-info-box">
		<div class="alignleft stat-info-left"><strong><?php echo __("Likes"); ?></strong><br /><span class="stat-info-number">3</span></div>
		<div class="alignleft stat-info-right"><?php echo __('%count% coming from ClickBacks', array('%count%' => '2')); ?></div>
	</div>
	<div class="alignleft css-arrow-big">
	</div>

	<div class="alignleft stat-info-box">
		<div class="alignleft stat-info-left"><strong><?php echo __("Spreads"); ?></strong><br /><span class="stat-info-number">847</span></div>
		<div class="alignleft stat-info-right"><?php echo __('%count% coming from ClickBacks', array('%count%' => '200')); ?></div>
	</div>
	<div class="alignleft css-arrow-big">
	</div>

	<div class="alignleft stat-info-box">
		<div class="alignleft stat-info-left"><strong><?php echo __("Media Penetration"); ?></strong><br /><span class="stat-info-number">8247</span></div>
		<div class="alignleft stat-info-right"><?php echo __('%count% coming from ClickBacks', array('%count%' => '2540')); ?></div>
	</div>
	<div class="alignleft css-arrow-big">
	</div>

</div>
<div id="demo-pie-charts" class="clearfix">
	<div class="alignleft" id="gender-chart">
		<?php include_partial('analytics/chart_pie_example', array('pChartsettings' =>
					'{
								"width": 290,
								"height": 130,
								"margin": [ 0, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#EBEAEA",
								"renderto":"gender-chart"
						}'
		)); ?>
	</div>
	<div class="alignleft" id="age-chart">
		<?php include_partial('analytics/chart_pie_example', array('pChartsettings' =>
					'{
								"width": 290,
								"height": 130,
								"margin": [ 0, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#EBEAEA",
								"renderto":"age-chart"
						}'
		)); ?>
	</div>
	<div class="alignleft" id="relation-chart">
		<?php include_partial('analytics/chart_pie_example', array('pChartsettings' =>
					'{
								"width": 290,
								"height": 130,
								"margin": [ 0, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#EBEAEA",
								"renderto":"relation-chart"
						}'
		)); ?>
	</div>
</div>
<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$pDomain->getId(), array('class' => 'alignright'));?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php slot('content') ?>
  <?php include_partial('url_table', array("pHostId" => $pDomain->getId(), "pFrom" => null, "pTo" => null, "pData" => $pTopActivitiesData)) ?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php if(count($pDeals) > 0) { ?>
<?php slot('content') ?>
	<?php include_partial('analytics/deal_table', array('pDeals' => $pDeals)); ?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
<?php } ?>


