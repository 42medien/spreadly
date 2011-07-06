<?php use_helper('Text'); ?>
<?php
slot('content');
use_helper('YiidNumber');
?>
<?php echo link_to("<span>".__('Details')."</span>", 'analytics/deal_details?deal_id='.$pDeal->getId(), array('class' => 'button alignright'));?>
<div id="analytics-bread">
	<ul class="bc-list clearfix">
		<li class="bc-first"></li>
		<li class="bc-gradient"><?php echo link_to(__('Dashboard'), 'analytics/index'); ?></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><strong><?php echo __('Overview for'.' "'.truncate_text($pDeal->getSummary(), 60).'"'); ?></strong></li>
		<li class="bc-last"></li>
	</ul>
</div>
<h2 class="sub_title"><?php echo __('Overview for deal %deal%', array('%deal%' => '"'.$pDeal->getSummary().'" from '.date("d.m.Y", strtotime($pDeal->getStartDate())).' to '.date("d.m.Y", strtotime($pEndDate))));?></h2>
<div id="navi" class="clearfix">
  <div class="stepBox alignleft">
    <div class="box_container alignleft">
      <div class="box">
        <p>
        	<?php echo __("Likes"); ?>
          	<a href="#" class="myqtip" title="<?php echo __('Number of likes received for your content on your url.'); ?>">
         		<img src="/img/qus_icon.png" alt="<?php echo __("Deals"); ?>" class="tooltip-icon" />
         	</a>
        </p>
	      <strong><?php echo $pDeal->getLikes(); ?></strong>
			</div>
    </div>
    <ul>
      <li>
        <p><span class="stepBox-text"><?php echo __('%count% coming from ClickBacks', array('%count%' => $pDeal->getClickbackLikes())); ?></span></p>
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
        <strong class="shares"><?php echo $pDeal->getShares(); ?></strong>
      </div>
    </div>
    <ul>
    	<?php foreach ($pDeal->getServices() as $key => $value) { ?>
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
        <strong class="media"><?php echo truncate_number($pDeal->getMediaPenetration()); ?></strong></div>
    </div>
   	<ul>
    	<?php foreach ($pDeal->getServices() as $key => $value) { ?>
      	<li class="<?php echo strtolower($key) ?>"><span><?php echo truncate_number($value['mp']); ?></span></li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>

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

<?php echo link_to("<span>".__('Details')."</span>", 'analytics/deal_details?deal_id='.$pDeal->getId(), array('class' => 'button alignright'));?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
