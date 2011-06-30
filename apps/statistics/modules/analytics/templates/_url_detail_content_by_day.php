<?php use_helper('Text', 'YiidUrl', 'YiidNumber'); ?>
<?php
if ($pUrlSummary) {
  slot('content')
?>
<?php if (isset($showdate)) {?>
	<h2 class="sub_title"><?php echo __('Likes from %date%', array('%date%' => $showdate)); ?></h2>
<?php } ?>
<div id="line-chart-example">
<?php include_partial('analytics/chart_line_activities_by_hours', array("pData" => $pUrlSummary)); ?>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}
?>

<?php slot('content') ?>
<h2 class="sub_title"><?php echo __('Like details for %url%', array('%url%' => $pUrl)); ?></h2>
<div class="data-tablebox two-line-table">
	<?php include_partial('analytics/like_detail_table', array('pUrls' => $pUrls)); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php
if ($pUrlSummary) {
  slot('content');
?>
<h2 class="sub_title"><?php echo __('Demographics for %url%', array('%url%' => $pUrlSummary->getUrl())); ?></h2>
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
            }', 'pData' => $pUrlSummary->getDemographics()
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
            }', 'pData' => $pUrlSummary->getDemographics()
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
            }', 'pData' => $pUrlSummary->getDemographics()
    )); ?>
  </div>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}
?>