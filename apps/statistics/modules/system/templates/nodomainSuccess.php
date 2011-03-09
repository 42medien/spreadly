<div class="clearfix" id="nodomain-content">
		<h1><?php echo __("You have not yet confirmed that you are the owner of a domain."); ?></h1>
	<p>
		<?php echo __('The confirmation of your domain ownership is required for activating the deal function of the Spread.ly button as well as the statistics section. Please confirm it now.'); ?>
	</p>
	<?php echo link_to('<span>'.__('Yes, I own of a domain').'</span>', 'domain_profiles/index', array('class' => 'button')); ?>
	<?php echo link_to('<span>'.__('No thanks').'</span>', '@configurator', array('class' => 'button')); ?>
</div>