  <div class="content-box-head">
    <h3><?php echo __('Verification code for'); ?> <?php echo $domain_profile->getUrl(); ?></h3>
  </div>
  <div class="content-box-body" id="claiming-profile-content">
		<p>
		  <?php echo __('Please copy & paste this code between the &lt;head&gt; and &lt;/head&gt; tags of your homepage (e.g. "index.html" or "index.php") and start the verification process from the list of wesites below, as soon as you\'re done:'); ?>
		</p>
		<input type="text" id="input-verify-code" value="<?php echo '<meta name=\'microid\' content=\''.$domain_profile->getVerificationToken().'\' />' ?>" />
		<a href="#" id="close-verify-code"><?php echo __('close');?></a>
  </div>


