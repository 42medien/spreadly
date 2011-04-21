<?php
use_helper('YiidNumber');

slot('content');
?>
<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$pDomainProfileId, array('class' => 'alignright'));?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;&nbsp;&gt;&nbsp;
	<?php echo link_to('Overview for '.$pHost->getHost(), 'analytics/domain_statistics?domainid='.$pDomainProfileId); ?>
</div>
<h2 class="sub_title"><?php echo __('All time overview for domain %domain%', array('%domain%' => $pHost->getHost()));?></h2>
  <div id="navi" class="clearfix">
    <div class="stepBox alignleft">
      <div class="box_container alignleft">
        <div class="box">
          <p>
          	<?php echo __("Likes"); ?>
          	<a href="#" class="helptip">
          		<img src="/img/qus_icon.png" alt="<?php echo __("Likes"); ?>" class="tooltip-icon" />
          	</a>
          </p>
          <div class="tooltip"><h3><?php echo __('Likes'); ?></h3><?php echo __('Number of likes received for your content on your url.'); ?></div>
	        <strong><?php echo $pHost->getLikes(); ?></strong>
      </div>
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
          <p>
          	<?php echo __("Spreads"); ?>
          	<a href="#" class="helptip">
          		<img src="/img/qus_icon.png" class="tooltip-icon" alt="<?php echo __("Spreads"); ?>"/>
          	</a>
          </p>
          <div class="tooltip"><h3><?php echo __('Spreads'); ?></h3><?php echo __("Total number of likes published in the social networks listed."); ?></div>
          <strong class="shares"><?php echo $pHost->getShares(); ?></strong></div>
      </div>
      <ul>
      <?php foreach ($pHost->getServices() as $key => $value) { ?>
        <li class="<?php echo strtolower($key) ?>"><span><?php echo truncate_number($value['l']); ?></span></li>
      <?php } ?>
      </ul>
    </div>
    <div class="stepBox mediaPartner alignleft">
      <div class="box_container alignleft">
        <div class="box">
          <p class="media_text_space">
          	<?php echo __("Media Penetration"); ?>
          	<a href="#" class="helptip">
          		<img src="/img/qus_icon.png" title="<?php echo __("Media Penetration"); ?>" alt="<?php echo __("Media Penetration"); ?>"  class="tooltip-icon" />
          	</a>
          </p>
          <div class="tooltip"><h3><?php echo __('Media Penetration'); ?></h3><?php echo __("Total number of contacts that are able to view the like referring to your content."); ?></div>
          <strong class="media"><?php echo $pHost->getMediaPenetration(); ?></strong></div>
      </div>
      <ul>
      <?php foreach ($pHost->getServices() as $key => $value) { ?>
        <li class="<?php echo strtolower($key) ?>"><span><?php echo truncate_number($value['mp']); ?></span></li>
      <?php } ?>
      </ul>
    </div>
  </div>
<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$pDomainProfileId, array('class' => 'alignright'));?>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
<?php echo link_to('Show Details', 'analytics/domain_detail?domainid='.$pDomainProfileId, array('class' => 'alignright clearfix'));?>

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
						}', 'pData' => $pHost->getDemographics()
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
						}', 'pData' => $pHost->getDemographics()
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