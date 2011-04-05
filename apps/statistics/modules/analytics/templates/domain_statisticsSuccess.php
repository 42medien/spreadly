<?php slot('content') ?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;
	<?php echo link_to($pDomain->getUrl(), 'analytics/domain_statistics?domainid='.$pDomain->getId()); ?>&nbsp;
	<?php echo __('Overview'); ?>
</div>
<h3><?php echo __('Overview domain %domain%', array('%domain%' => $pDomain->getUrl()));?></h3>
<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$pDomain->getId(), array('class' => 'alignright'));?>
<div class="clearfix">
	<div class="alignleft" style="padding: 30px; border: 1px solid #ccc; margin: 10px;">3 Likes</div>
	<div class="alignleft" style="padding: 30px; border: 1px solid #ccc; margin: 10px;">8 Spreads</div>
	<div class="alignleft" style="padding: 30px; border: 1px solid #ccc; margin: 10px;">Media Penetration 5400</div>
</div>
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


