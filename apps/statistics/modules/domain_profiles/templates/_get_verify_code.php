<div class="clearfix nameselection-bar">
	<div><?php echo __('Please copy & paste this code between the &lt;head&gt; and &lt;/head&gt; tags of your homepage (e.g. "index.html" or "index.php") and start the verification process from the list of wesites below, as soon as you\'re done:'); ?></div>
	<a href="#" class="blue-btn" id="btn-cp-microid" title="Copy">Copy</a>
	<label><input type="text" id="input-verify-code" value="<?php echo '<meta name=\'microid\' content=\''.$domain_profile->getVerificationToken().'\' />' ?>" class="nameinput"></label>
	<a href="#" class="blue-btn" id="close-verify-code" title="Close">Close</a>
</div>