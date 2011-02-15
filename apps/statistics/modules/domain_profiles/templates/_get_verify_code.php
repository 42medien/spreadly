<!--veryfied box start -->
	<div class="grboxtop"><span></span></div>
  <div class="grboxmid">
  	<div class="grboxmid-content">
			<div class="graybox clearfix veryficationbox">
      	<h3 class="verifytitle"><?php echo __('Verification code for'); ?> <?php echo $domain_profile->getUrl(); ?></h3>
        <p><?php echo __('Please copy & paste this code between the &lt;head&gt; and &lt;/head&gt; tags of your homepage (e.g. "index.html" or "index.php") and start the verification process from the list of wesites below, as soon as you\'re done:'); ?></p>
				<div>
					<label class="textfield-wht">
						<span><input type="text"  id="input-verify-code" class="wd870" name="" value="<?php echo '<meta name=\'microid\' content=\''.$domain_profile->getVerificationToken().'\' />' ?>"  /></span></label> <a href="#" id="close-verify-code" title="Close" class="alignleft closemeta">Close</a>
				</div>
      </div>
    </div>
  </div>
	<div class="grboxbot"><span></span></div>

