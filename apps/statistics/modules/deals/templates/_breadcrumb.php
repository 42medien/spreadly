<?php $lAction = $sf_context->getActionName();?>
<ul class="tabs alignleft">
	<li class="first <?php echo ($lAction == 'step_campaign')? 'active': ""; ?>">
		<?php echo link_to_if($pDeal->canReset_to_campaign(), __('Schritt 1: Kampagne'), 'deals/step_campaign?did='.$pDeal->getId()) ?>
	</li>
	<li class="<?php echo ($lAction == 'step_share')? 'active': ""; ?>">
		<?php echo link_to_if($pDeal->canReset_to_share(), __('Schritt 2: Deal'), 'deals/step_share?did='.$pDeal->getId()) ?>
	</li>
	<li class="<?php echo ($lAction == 'step_coupon')? 'active': ""; ?>">
		<?php echo link_to_if($pDeal->canReset_to_coupon(), __('Schritt 3: Gutschein'), 'deals/step_coupon?did='.$pDeal->getId()) ?>
	</li>
	<li class="<?php echo ($lAction == 'step_billing')? 'active': ""; ?>">
		<?php echo link_to_if($pDeal->canReset_to_billing(), __('Schritt 4: Rechnung'), 'deals/step_billing?did='.$pDeal->getId()) ?>
	</li>
	<li class="<?php echo ($lAction == 'step_verify')? 'active': ""; ?>">
		<span><?php echo __('Schritt 5: Prüfen') ?></span>
	</li>
</ul>