<?php use_helper('Text'); ?>

<?php slot('content'); ?>
<div id="analytics-bread">
	<ul class="bc-list clearfix">
		<li class="bc-first"></li>
		<li class="bc-gradient"><?php echo link_to(__('Dashboard'), 'analytics/index'); ?></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><strong><?php echo link_to(__('Overview for "%deal%"', array("%deal%" => truncate_text($pDeal->getSummary(), 50))), 'analytics/deals?deal_id='.$pDeal->getId(), array('title' => 'Overview for '.$pDeal->getSummary())); ?></strong></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><strong><?php echo __('Details for "%deal%"', array("%deal%" => truncate_text($pDeal->getSummary(), 50), 'title' => 'Overview for '.$pDeal->getSummary()));?></strong></li>
		<li class="bc-last"></li>
	</ul>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php
use_helper('Text', 'YiidUrl', "YiidNumber");

if (count($pDeal->getLikes())) {
  slot('content')
?>
<h2 class="sub_title"><?php echo __('Details for deal "%deal%', array('%deal%' => $pDeal->getSummary().'"'.'&nbsp;from&nbsp;'.date("d.m.Y", strtotime($pDeal->getStartDate())).'&nbsp;to&nbsp;'.date("d.m.Y", strtotime($pEndDate))));?></h2>
<div id="line-chart-example">
<?php include_partial('analytics/chart_line_activities',
        array(
          "pData" => $pLikes,
          'pFromYear' => date('Y', strtotime($pDeal->getStartDate())),
          'pFromMonth' => date('m', strtotime($pDeal->getStartDate())),
          'pFromDay' => date('d', strtotime($pDeal->getStartDate())),
        	'pChartsettings' => '{
						"zoomtype": "x"
					}'
        )
      ); ?>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}
?>

<?php slot('content') ?>

<?php include_partial('deal_analytics/deal_detail_table', array('pDeal' => $pDeal)); ?>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content'); ?>
<h2 class="sub_title"><?php echo __('Demographic overview'); ?></h2>
<?php if($pDeal->getDemographics() && count($pDeal->getDemographics()) > 0) {?>
<div id="pie-charts" class="clearfix">
	<div class="alignleft" id="gender-chart">
		<?php include_partial('analytics/chart_pie_gender', array('pChartsettings' =>
					'{
								"width": 305,
								"height": 180,
								"margin": [ 40, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#e1e1e1",
								"renderto":"gender-chart"
						}', 'pData' => $pDeal->getDemographics()
		)); ?>
	</div>
	<div class="alignleft" id="age-chart">
		<?php include_partial('analytics/chart_pie_age', array('pChartsettings' =>
					'{
								"width": 305,
								"height": 180,
								"margin": [ 40, 20, 10, 20],
								"plotsize": "50%",
								"bgcolor" : "#e1e1e1",
								"renderto":"age-chart"
						}', 'pData' => $pDeal->getDemographics()
		)); ?>
	</div>
	<div class="alignleft" id="relation-chart">
		<?php include_partial('analytics/chart_pie_relationship', array('pChartsettings' =>
					'{
								"width": 305,
								"height": 180,
								"margin": [ 40, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#e1e1e1",
								"renderto":"relation-chart"
						}', 'pData' => $pDeal->getDemographics()
		)); ?>
	</div>
</div>
<?php } else { ?>
	<?php echo __('Sorry, we have no demografical statistics for that deal yet'); ?>
<?php } ?>
<?php
	end_slot();
	include_partial('global/graybox');
?>

<?php slot('content') ?>
<h2 class="sub_title"><?php echo __('URL overview'); ?></h2>
<div class="data-tablebox two-line-table">
	<?php include_partial('deal_analytics/top_pages_table', array('pUrls' => $pUrlSummaries)); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
<h2 class="sub_title"><?php echo __('Top Influencer'); ?></h2>
<div class="data-tablebox two-line-table">
	<?php include_partial('deal_analytics/top_influencer_table', array('pUrls' => $pUrls)); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>