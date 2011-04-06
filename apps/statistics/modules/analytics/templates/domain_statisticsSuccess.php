<?php slot('content') ?>
<div id="analytics-bread">
  <?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;
  <?php echo link_to($host->getHost(), 'analytics/domain_statistics?host='.$host->getHost()); ?>&nbsp;
  <?php echo __('Overview'); ?>
</div>
<h3><?php echo __('Overview domain %domain%', array('%domain%' => $host->getHost()));?></h3>
<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$host->getHost(), array('class' => 'alignright'));?>
<div class="clearfix">
  <div class="alignleft" style="padding: 30px; border: 1px solid #ccc; margin: 10px;"><?php echo $host->getLikes(); ?> Likes</div>
  <div class="alignleft" style="padding: 30px; border: 1px solid #ccc; margin: 10px;"><?php echo $host->getShares(); ?> Shares</div>
  <div class="alignleft" style="padding: 30px; border: 1px solid #ccc; margin: 10px;">Media Penetration <?php echo $host->getMediaPenetration(); ?></div>
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