<?php slot('headline') ?>
	<h2><?php echo __('Your deals'); ?> <span><?php echo __('List of all your recent deals (%count%)', array('%count%' => count($pActivity))); ?></span></h2>
<?php end_slot(); ?>
<div id="deallist">
	<?php if($pActivity->hasNext()) { ?>
			<?php
			 	foreach($pActivity as $lActivity) {
			  	include_component('deals','coupon_used', array('pActivityId' => $lActivity->getId()));
			 	}
			?>
<?php } ?>
</div>
