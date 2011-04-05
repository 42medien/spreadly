<div><?php echo __('Deal'); ?>: <?php echo $pDeal->getSummary(); ?></div>
<?php include_partial('analytics/period_selection'); ?>
<a href="/">dumdidum</a>
<div><?php echo __('Type'); ?>: <?php echo __('Deals'); ?></div>
<div><?php echo __('You are here'); ?>: <?php echo link_to('Dashboard', 'analytics/index'); ?> <?php echo link_to($pDeal->getSummary(), 'analytics/statistics?dealid='.$pDeal->getId().'&type=deal'); ?></div>