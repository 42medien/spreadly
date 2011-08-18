<?php $lAction = $sf_context->getActionName();?>

<?php slot('content') ?>
<div id="analytics-bread">
	<ul class="bc-list clearfix">
		<li class="bc-first"></li>
		<li class="bc-gradient <?php echo ($lAction == 'step_campaign')? 'bc-highlight': ""; ?>">
		  <?php echo link_to_if($pDeal->canReset_to_campaign(), __('Schritt 1: Kampagne'), 'deals/step_campaign?did='.$pDeal->getId()) ?>
		</li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient <?php echo ($lAction == 'step_share')? 'bc-highlight': ""; ?>">
		  <?php echo link_to_if($pDeal->canReset_to_share(), __('Schritt 2: Deal'), 'deals/step_share?did='.$pDeal->getId()) ?>
		</li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient <?php echo ($lAction == 'step_coupon')? 'bc-highlight': ""; ?>">
		  <?php echo link_to_if($pDeal->canReset_to_coupon(), __('Schritt 3: Gutschein'), 'deals/step_coupon?did='.$pDeal->getId()) ?>
		</li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient <?php echo ($lAction == 'step_billing')? 'bc-highlight': ""; ?>">
		  <?php echo link_to_if($pDeal->canReset_to_billing(), __('Schritt 4: Rechnung'), 'deals/step_billing?did='.$pDeal->getId()) ?>
		</li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient <?php echo ($lAction == 'step_verify')? 'bc-highlight': ""; ?>">
		  <?php echo __('Schritt 5: Überprüfen') ?>
		</li>
		<li class="bc-last"></li>
	</ul>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
