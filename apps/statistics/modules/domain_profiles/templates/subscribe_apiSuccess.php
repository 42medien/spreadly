<form name="api-subscription-form" class="clearfix" id="api-subscription-form" action="<?php echo url_for('domain_profiles/check_endpoint'); ?>">
<input type="hidden" name="host_id" value="<?php echo $pHostId; ?>" />
<div id="subscribe-api-box" class="clearfix">
	<h2><?php echo __('Advanced Notifications Setup'); ?></h2>
	<p><?php echo __('With Advanced Notifications you are able to track every "Like" or "Deal" on your website in realtime yourself: the Spreadly API lets you write your own code to react in every imaginable way to the activities of users on your site. More details, documentation and example code for developers can be found %devdoku%.', array('%devdoku%' => link_to('here', 'http://code.google.com/p/spreadly/wiki/PuSH_API', array('target' => '_blank'))) ); ?></p>
	<div class="clearfix">
		<div class="btnwording alignleft">
			<strong><?php echo __('Your Endpoint'); ?></strong>
			<span><?php echo __('(The url Spreadly should notifyin case of new likes or deals)'); ?></span>
		</div>
		<label class="inputlabel" id="endpointlabel">
	  		<input type="text" id="ep-url" class="mirror-value inputfield" value="<?php echo ($pEndpoint)?$pEndpoint->getCallback():"http://" ?>" name="ep-url">
	  </label>
	  <div>
				<a href="#" title="Verify Endpoint" id="subscribe-api-button" class="blue-btn alignleft" <?php echo ($pEndpoint)?'style="display:none;"':'';?> ><span><?php echo __('Validate the setup of your endpoint'); ?></span></a>
				<a href="/domain_profiles/unsubscribe_api?host_id=<?php echo $pHostId; ?>" title="Unsubscribe Endpoint" id="unsubscribe-api-button" class="blue-btn" <?php echo (!$pEndpoint)?'style="display:none;"':'';?>><span><?php echo __('Stop subscription'); ?></span></a>
		</div>
	</div>

	<?php if ($pEndpoint) {?>
		<div id="endpoint-stats">
			<h3><?php echo __('24h Status:'); ?></h3>
			<span class="ep-stat-count"><?php echo __('%ok% OK', array('%ok%' => $pOk)); ?></span>
			<span class="ep-stat-count"><?php echo __('%to% connection timeout', array('%to%' => $pTimeout)); ?></span>
			<span class="ep-stat-count"><?php echo __('%wr% wrong response', array('%wr%' => $pResponseFail)); ?></span>
		</div>
	<?php } ?>

	<div id="verify-form-success" class="form-response <?php echo (!$pEndpoint)?'hide':'';?>">
		<span class="success"><?php echo __('Your endpoint is valid and you are successfully subscribed to all likes and deals on %domain%. If you change the url of your endpoint, you must validate again.', array('%domain%' => link_to($pDomainProfile->getDomain(), $pDomainProfile->getDomain()))); ?></span>
	</div>
	<div id="verify-form-error" class="form-response hide">
		<span class="error"></span>
	</div>
	<div id="unsubscribe-api" class="clearfix form-response <?php echo (!$pEndpoint)?'hide':'';?>">
		<?php echo __('If you want to stop your subscription, click here:'); ?>
		<a href="/domain_profiles/unsubscribe_api?host_id=<?php echo $pHostId; ?>" title="Unsubscribe Endpoint" id="unsubscribe-api-button" class="blue-btn"><span><?php echo __('Stop subscription'); ?></span></a>
	</div>

</div>
</form>

<script type="text/javascript">
	ApiVerifier.init();
</script>
