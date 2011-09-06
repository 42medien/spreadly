<?php
use_helper('Text', 'YiidUrl', "YiidNumber");

if ($pLikes) {
  slot('content')
?>
<?php if (isset($showdate)) {?>
	<h2 class="sub_title"><?php echo __('Statistics from %date%', array('%date%' => $showdate)); ?></h2>
<?php } ?>
<div id="line-chart-example">
<?php include_partial('analytics/chart_line_activities',
        array(
          "pData" => $pLikes,
          'pFromYear' => date('Y', strtotime($pStartDay)),
          'pFromMonth' => date('m', strtotime($pStartDay)),
          'pFromDay' => date('d', strtotime($pStartDay)),
        	'pChartsettings' => '{
						"zoomtype": ""
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
<h2 class="sub_title"><?php echo __('URL overview'); ?></h2>
<div class="data-tablebox two-line-table">
	<?php include_partial('analytics/url_table', array('pUrls' => $pUrls, 'pDomainProfile' => $pDomainProfile, 'pShowUrl' => true)); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php
if ($pHostSummary) {
  slot('content');
?>
<h2 class="sub_title"><?php echo __('Demographic overview'); ?></h2>
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
            }', 'pData' => $pHostSummary[$pDomainProfile->getUrl()]['value']['d']
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
            }', 'pData' => $pHostSummary[$pDomainProfile->getUrl()]['value']['d']
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
            }', 'pData' => $pHostSummary[$pDomainProfile->getUrl()]['value']['d']
    )); ?>
  </div>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}

include_partial('global/graybox');
?>