<?php slot('content') ?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;&gt;&nbsp;
	<?php echo link_to($host->getHost(), 'analytics/domain_statistics?domainid='.$host->getId()); ?>&nbsp;&gt;&nbsp;
	<?php echo __('Overview'); ?>
</div>

<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$host->getId(), array('class' => 'alignright'));?>
<h2><?php echo __('Overview for domain %domain%', array('%domain%' => $host->getHost()));?></h2>
<div class="clearfix" id="stat-infos">
	<div class="alignleft stat-info-box">
		<div class="alignleft stat-info-left"><strong><?php echo __("Likes"); ?></strong><br /><span class="stat-info-number"><?php echo $host->getLikes(); ?></span></div>
		<div class="alignleft stat-info-right"><?php echo __('%count% coming from ClickBacks', array('%count%' => $host->getClickbackLikes())); ?></div>
	</div>
	<div class="alignleft css-arrow-big">
	</div>

	<div class="alignleft stat-info-box">
		<div class="alignleft stat-info-left"><strong><?php echo __("Spreads"); ?></strong><br /><span class="stat-info-number"><?php echo $host->getShares(); ?></span></div>
		<div class="alignleft stat-info-right"><?php echo __('%count% coming from ClickBacks', array('%count%' => '200')); ?></div>
	</div>
	<div class="alignleft css-arrow-big">
	</div>

	<div class="alignleft stat-info-box">
		<div class="alignleft stat-info-left"><strong><?php echo __("Media Penetration"); ?></strong><br /><span class="stat-info-number"><?php echo $host->getMediaPenetration(); ?></span></div>
		<div class="alignleft stat-info-right"><?php echo __('%count% coming from ClickBacks', array('%count%' => $host->getClickbacks())); ?></div>
	</div>
	<div class="alignleft css-arrow-big">
	</div>

</div>
<div id="demo-pie-charts" class="clearfix">
	<div class="alignleft" id="gender-chart">
		<?php include_partial('analytics/chart_pie_example', array('pChartsettings' =>
					'{
								"width": 300,
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
								"width": 300,
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
								"width": 300,
								"height": 130,
								"margin": [ 0, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#EBEAEA",
								"renderto":"relation-chart"
						}'
		)); ?>
	</div>
</div>

<?php echo link_to('Show Details', 'analytics/domain_detail?host='.$host->getHost(), array('class' => 'alignright'));?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php
  slot('content');
    include_component('analytics', 'top_url_overall_table', array("host" => $host->getHost()));
  end_slot();
  include_partial('global/graybox');

  slot('content');
   include_component('analytics', 'active_deal_table', array("host" => $host->getHost()));
  end_slot();
  include_partial('global/graybox');
?>