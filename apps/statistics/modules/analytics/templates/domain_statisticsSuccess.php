<?php slot('content') ?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;&gt;&nbsp;
	<?php echo link_to($pHost->getHost(), 'analytics/domain_statistics?domainid='.$pDomainProfileId); ?>&nbsp;&gt;&nbsp;
	<?php echo __('Overview'); ?>
</div>

<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$pDomainProfileId, array('class' => 'alignright'));?>

<h2><?php echo __('Overview for domain %domain%', array('%domain%' => $pHost->getHost()));?></h2>

  <div id="navi" class="clearfix">
    <div class="stepBox alignleft">
      <div class="box_container alignleft">
        <div class="box">
          <p><?php echo __("Likes"); ?><a href="#" ><img src="/img/qus_icon.png" title="Deals" alt="Deals" class="deals_ques" /></a></p>
          <strong><?php echo $pHost->getLikes(); ?></strong></div>
      </div>
      <ul>
        <li>
          <p><span class="stepBox-text"><?php echo __('%count% coming from ClickBacks', array('%count%' => $pHost->getClickbackLikes())); ?></span></p>
        </li>
      </ul>
    </div>
    <div class="stepBox shares_box alignleft">
      <div class="box_container alignleft">
        <div class="box">
          <p><?php echo __("Spreads"); ?><a href="#"><img src="/img/qus_icon.png" title="Shares" class="share_ques"  alt="Shares"/></a></p>
          <strong class="shares"><?php echo $pHost->getShares(); ?></strong></div>
      </div>
      <ul>
      <?php foreach ($pHost->getServices() as $key => $value) { ?>
        <li class="<?php echo $key ?>"><span><?php echo $value['l']; ?></span></li>
      <?php } ?>
      </ul>
    </div>
    <div class="stepBox mediaPartner alignleft">
      <div class="box_container alignleft">
        <div class="box">
          <p class="media_text_space"><?php echo __("Media Penetration"); ?><a href="#"><img src="/img/qus_icon.png" title="Media Penetration" alt="Media Penetration" class="media_ques" /></a></p>
          <strong class="media"><?php echo $pHost->getMediaPenetration(); ?></strong></div>
      </div>
      <ul>
      <?php foreach ($pHost->getServices() as $key => $value) { ?>
        <li class="<?php echo $key ?>"><span><?php echo $value['mp']; ?></span></li>
      <?php } ?>
      </ul>
    </div>
  </div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
<div id="demo-pie-charts" class="clearfix">
	<div class="alignleft" id="gender-chart">
		<?php include_partial('analytics/chart_pie_gender', array('pChartsettings' =>
					'{
								"width": 290,
								"height": 170,
								"margin": [ 30, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#EBEAEA",
								"renderto":"gender-chart"
						}', 'pData' => $pHost->getDemographics()
		)); ?>
	</div>
	<div class="alignleft" id="age-chart">
		<?php include_partial('analytics/chart_pie_age', array('pChartsettings' =>
					'{
								"width": 290,
								"height": 170,
								"margin": [ 30, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#EBEAEA",
								"renderto":"age-chart"
						}', 'pData' => $pHost->getDemographics()
		)); ?>
	</div>
	<div class="alignleft" id="relation-chart">
		<?php include_partial('analytics/chart_pie_relationship', array('pChartsettings' =>
					'{
								"width": 290,
								"height": 170,
								"margin": [ 30, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#EBEAEA",
								"renderto":"relation-chart"
						}', 'pData' => $pHost->getDemographics()
		)); ?>
	</div>
</div>

<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$pDomainProfileId, array('class' => 'alignright'));?>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php
  slot('content');
    include_component('analytics', 'top_url_overall_table', array("host" => $pHost->getHost()));
  end_slot();
  include_partial('global/graybox');

  slot('content');
   include_component('analytics', 'active_deal_table', array("host" => $pHost->getHost()));
  end_slot();
  include_partial('global/graybox');
?>