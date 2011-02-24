<div class="clearfix" id="nodomain-content">
		<h1><?php echo __("Sie haben noch nicht bestätigt, dass Sie Inhaber einer Domain sind."); ?></h1>
	<p>
		<?php echo __('Bitte erledigen Sie diesen Schritt als Erstes, da dies die Voraussetzung für die Nutzung von Statistik- und Dealfunktionen ist.'); ?>
	</p>
	<?php echo link_to('<span>'.__('Ja, jetzt eine Domain bestätigen').'</span>', 'domain_profiles/index', array('class' => 'button')); ?>
	<?php echo link_to('<span>'.__('Nein danke').'</span>', '@configurator', array('class' => 'button')); ?>
</div>