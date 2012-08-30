<div class="page-titlecontent">
	<h2><?php echo __('Überblick für '.' '.$pHost->getHost()); ?></h2>
	<p><?php echo __('Hier sehen Sie die Gesamtstatistiken über Ihre Domain %domain%, allgemeine Informationen zu Ihren Usern und Ihre Einnahmen.', array('%domain%' => $pHost->getHost())); ?></p>
</div>
<?php
use_helper('YiidNumber', 'CustomTags');

slot('content');
?>
<?php echo link_to("<span>".__('Details')."</span>", 'analytics/domain_detail?domainid='.$pDomainProfileId, array('class' => 'more-button alignright'));?>
<div id="analytics-bread">
	<ul class="bc-list clearfix">
		<li class="bc-first"></li>
		<li class="bc-gradient"><?php echo link_to(__('Dashboard'), 'analytics/index'); ?></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><strong><?php echo __('Overview for'.' '.$pHost->getHost()); ?></strong></li>
		<li class="bc-last"></li>
	</ul>
</div>
  <div id="navi" class="clearfix">
    <div class="stepBox alignleft">
      <div class="box_container alignleft">
        <div class="box">
          <p>
          	<?php echo __("Likes"); ?>
          	<a href="#" class="myqtip" title="<?php echo __('Number of likes received for your content on your url.'); ?>">
          		<img src="/img/qus_icon.png" alt="<?php echo __("Likes"); ?>" class="tooltip-icon" />
          	</a>
          </p>
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
          	<a href="#" class="myqtip" title="<?php echo __("Total number of likes published in the social networks listed."); ?>">
          		<img src="/img/qus_icon.png" class="tooltip-icon" alt="<?php echo __("Spreads"); ?>"/>
          	</a>
          </p>
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
          	<a href="#" class="myqtip" title="<?php echo __("Total number of contacts that are able to view the like referring to your content."); ?>">
          		<img src="/img/qus_icon.png" class="tooltip-icon" />
          	</a>
          </p>
          <strong class="media"><?php echo truncate_number($pHost->getMediaPenetration()); ?></strong></div>
      </div>
      <ul>
      <?php foreach ($pHost->getServices() as $key => $value) { ?>
        <li class="<?php echo strtolower($key) ?>"><span><?php echo truncate_number($value['mp']); ?></span></li>
      <?php } ?>
      </ul>
    </div>
  </div>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php slot('content'); ?>
<h2 class="sub_title"><?php echo __("Dominant Tags"); ?></h2>
<p><?php echo __("Subline"); ?>:</p>
<?php
  echo @simple_tag_cloud($pDomainProfile->getTags());
end_slot();
include_partial('global/graybox');
?>

<?php slot('content') ?>

<div id="pie-charts" class="clearfix">
	<div class="alignleft" id="gender-chart">
		<?php include_partial('analytics/chart_pie_gender', array('pChartsettings' =>
					'{
								"width": 300,
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
								"width": 300,
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
								"width": 300,
								"height": 180,
								"margin": [ 40, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#e1e1e1",
								"renderto":"relation-chart"
						}', 'pData' => $pHost->getDemographics()
		)); ?>
	</div>
</div>

<?php echo link_to("<span>".__('Details')."</span>", 'analytics/domain_detail?domainid='.$pDomainProfileId, array('class' => 'more-button alignright'));?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content'); ?>
<h2 class="sub_title"><?php echo __('You earned %sum% € via Spreadly deals. See the monthly overview:', array('%sum%' => $pDomainProfile->getCommissionSum())); ?></h2>
	<div>
		<?php include_partial('analytics/chart_bar_publisher', array('pChartsettings' =>
					'{
								"width": 305,
								"height": 180,
								"margin": [ 40, 0, 10, 10],
								"plotsize": "50%",
								"bgcolor" : "#e1e1e1",
								"renderto":"relation-chart"
						}', 'pData' => $pDomainProfile->getCommissionStats()
		)); ?>
	</div>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php slot('content'); ?>
	<div class="data-tablebox two-line-table">
		<?php include_partial('analytics/url_table', array('pUrls' => $urls, 'pDomainProfile' => $pDomainProfile)); ?>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>