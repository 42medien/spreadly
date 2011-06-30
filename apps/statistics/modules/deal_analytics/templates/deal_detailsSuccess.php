<?php slot('content'); ?>
<div id="analytics-bread">
	<ul class="bc-list clearfix">
		<li class="bc-first"></li>
		<li class="bc-gradient"><?php echo link_to(__('Dashboard'), 'analytics/index'); ?></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><strong><?php echo link_to(__('Overview for "'.$pDeal->getSummary().'"'), 'analytics/deals?deal_id='.$pDeal->getId()); ?></strong></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><strong><?php echo __('Details for "'.$pDeal->getSummary().'"');?></strong></li>
		<li class="bc-last"></li>
	</ul>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>