<?php slot('content'); ?>

<div class="footer-outer-box clearfix">

	<div class="footer-box">
		<h3><?php echo __('Home'); ?></h3>
		<div class="list-box">
			<ul class="footer-list">
				<li><?php echo link_to(__('Buttons'), 'configurator/index'); ?></li>
				<li><?php echo link_to(__('Domains'), 'domain_profiles/index'); ?></li>
				<li><?php echo link_to(__('Analytics'), 'analytics/index'); ?></li>
				<li><?php echo link_to(__('Deals'), 'deals/index'); ?></li>
			</ul>
		</div>
	</div>

	<div class="footer-box">
		<h3><?php echo __('Support'); ?></h3>
		<div class="list-box">
			<ul class="footer-list">
				<li><?php echo link_to(__('GetSatisfaction'), 'http://getsatisfaction.com/spreadly', array('target' => '_blank')); ?></li>
				<li><?php echo link_to(__('Help via Twitter'), 'http://twitter.com/spreadly_helps', array('target' => '_blank')); ?></li>
				<li><a href="mailto:info@spreadly.com"><?php echo __('Help via Email'); ?></a></li>
			</ul>
		</div>
	</div>

	<div class="footer-box">
		<h3><?php echo __('Services'); ?></h3>
		<div class="list-box">
			<ul class="footer-list">
				<li><?php echo link_to(__('Chrome Extension'), 'https://chrome.google.com/extensions/detail/leclmjclggfnkhdpkgnagcdnhnomapda', array('target' => '_blank')); ?></li>
				<li><?php echo link_to(__('Other Extensions'), 'http://code.google.com/p/spreadly/downloads/list', array('target' => '_blank')); ?></li>
				<li><?php echo link_to(__('Wordpress Plugin'), 'http://wordpress.org/extend/plugins/yiidit/', array('target' => '_blank')); ?></li>
				<li><?php echo link_to(__('Developers'), 'http://code.google.com/p/spreadly/', array('target' => '_blank')); ?></li>
				<li><?php echo link_to(__('Api'), 'http://code.google.com/p/spreadly/wiki/PuSH_API', array('target' => '_blank')); ?></li>
			</ul>
		</div>
	</div>

	<div class="footer-box">
		<h3><?php echo __('Company'); ?></h3>
		<div class="list-box">
			<ul class="footer-list">
				<li><?php echo link_to(__('Our Blog'), 'http://blog.spreadly.com/', array('target' => '_blank')); ?></li>
				<li><?php echo link_to(__('About ekaabo'), 'http://ekaabo.de/', array('target' => '_blank')); ?></li>
				<li><?php echo link_to(__('TOS'), 'system/tos'); ?></li>
				<li><?php echo link_to(__('Privacy'), 'system/privacy'); ?></li>
				<li><?php echo link_to(__('Imprint'), '@imprint'); ?></li>
			</ul>
		</div>
	</div>

	<div class="footer-box">
		<h3><?php echo __('Contact'); ?></h3>
		<div class="list-box last">
			<ul class="footer-list last">
				<li><a href="mailto:info@spreadly.com"><?php echo __('Send email'); ?></a></li>
				<li><?php echo link_to(__('Spread.ly @ Facebook'), 'http://www.facebook.com/spreadly', array('target' => '_blank')); ?></li>
				<li><?php echo link_to(__('Spread.ly @ Twitter'), 'http://twitter.com/spreadly', array('target' => '_blank')); ?></li>
			</ul>
		</div>
	</div>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "overlay";
  feedback_widget_options.company = "ekaabo";
  feedback_widget_options.placement = "left";
  feedback_widget_options.color = "#222";
  feedback_widget_options.style = "idea";

  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>