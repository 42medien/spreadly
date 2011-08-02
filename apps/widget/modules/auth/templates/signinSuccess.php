<?php slot('headline') ?>
<?php if ($has_credentials == true) { ?>
	<h2><?php echo __('Please choose your favorite service for sharing'); ?></h2>
	<span class="additional-info"><?php echo __('You can add additional services anytime later'); ?></span>
<?php } else { ?>
	<h2><?php echo __('Please connect with your facebook-profile'); ?></h2>
	<span><?php echo __('You can add additional services anytime later'); ?></span>
<?php } ?>
<?php end_slot(); ?>

  <ul id="logos_big" class="normal_list small_size important clearfix">
    <li id="facebook_area"><a id="facebook_logo" class="service_icon" href="<?php echo url_for("@signinto?service=facebook", true); ?>">Facebook</a></li>
    <li id="twitter_area"><a id="twitter_logo" class="service_icon" href="<?php echo url_for("@signinto?service=twitter", true); ?>">Twitter</a></li>
    <li id="linkedin_area"><a id="linkedin_logo" class="service_icon" href="<?php echo url_for("@signinto?service=linkedin", true); ?>">Linkedin</a></li>
    <li id="google_area"><a id="google_logo" class="service_icon" href="<?php echo url_for("@signinto?service=google", true); ?>">Google Buzz</a></li>
  </ul>
