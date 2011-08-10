<?php slot('content') ?>
<div id="analytics-bread">
	<ul class="bc-list clearfix">
		<li class="bc-first"></li>
		<li class="bc-gradient">
		  <?php echo link_to_if($pDeal->canReset_to_campaign(), __('Step 1: Campaign'), 'deals/step_campaign?did='.$pDeal->getId()) ?>
		</li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient">
		  <?php echo link_to_if($pDeal->canReset_to_share(), __('Step 2: Share'), 'deals/step_share?did='.$pDeal->getId()) ?>
		</li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient">
		  <?php echo link_to_if($pDeal->canReset_to_coupon(), __('Step 3: Coupon'), 'deals/step_coupon?did='.$pDeal->getId()) ?>
		</li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient">
		  <?php echo link_to_if($pDeal->canReset_to_billing(), __('Step 4: Billing'), 'deals/step_billing?did='.$pDeal->getId()) ?>
		</li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient">
		  <?php echo __('Step 5: Verify') ?>
		</li>
		<li class="bc-last"></li>
	</ul>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
