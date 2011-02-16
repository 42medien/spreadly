<div class="dashboard">
  <?php slot('content') ?>
    <a href="/likebutton/index" title="Copy code" class="button header"><span><?php echo __('GO!');?></span></a>
    <h3 class="verifytitle"><?php echo __('Generate Button Codes')?></h3>
    <p><?php echo __('The first thing you might want to do, is creating button codes for your site (or sites).');?></p>
    <p><?php echo __('The yiid wizard will lead you through the creation process, ending up with a simple cut, copy & paste procedure to get your individual yiid button running on your site.');?></p>
    <p><?php echo __("If you're using one of the many supported softwares like e.g. Wordpress or Joomla, you will be redirected to the appropriate plugin download site instead, where you will find instructions on how to integrate this plugin into your site.");?></p>
    <p><?php echo __("If you face any problems, please get in touch using");?> <a href="mailto: info@yiid.com">info@yiid.com</a></p>  
  <?php end_slot(); ?>
  <?php include_partial('global/graybox', array("twoCol" => true)); ?>

  <?php slot('content') ?>
    <a href="/domain_profiles/index" title="Copy code" class="button header"><span><?php echo __('GO!');?></span></a>
    <h3 class="verifytitle"><?php echo __('Claim Your Websites')?></h3>
    <p><?php echo __('To keep access to your data secure, a couple of yiids features is only accessable after successfully claiming your ownership of your website.');?></p>
    <p><?php echo __('Yiid has a simplified process for that: we create a so called MicroId for you, which combines your domain and your email address into a unique key.');?></p>
    <p><?php echo __("You only have to copy & paste this MicroId meta tag into the <head> section of your homepage, kick off the verification process on yiid and you're done.");?></p>
    <p><?php echo __("In case of problems, please contact");?> <a href="mailto: info@yiid.com">info@yiid.com</a></p>
  
  <?php end_slot(); ?>
  <?php include_partial('global/graybox', array("twoCol" => true)); ?>


  <?php slot('content') ?>
    <a href="/analytics/index" title="Copy code" class="button header"><span><?php echo __('GO!');?></span></a>
    <h3 class="verifytitle"><?php echo __('Get Your Analytics')?></h3>
    <p><?php echo __("Yiid analytics are probably the most advanced social tracking tool available today: you can not only see the number of likes, created by clicking the yiid button, but you can also see the networks that were used for sharing, the number of friends that were reached by this like and - most important - the number of clickbacks aka new users - coming back to your site, based on the original like.");?></p>
    <p><?php echo __("This is the first time that the complete social recommendation circle gets transparent and trackable.");?></p>
    <p><?php echo __("To protect your data, analytics are only available after successfully claiming a site.");?></p>
    <p><?php echo __("If you have any questions about the statistics, please mail to");?> <a href="mailto: info@yiid.com">info@yiid.com</a></p>
  <?php end_slot(); ?>
  <?php include_partial('global/graybox', array("twoCol" => true)); ?>

  <?php slot('content') ?>
    <h3 class="verifytitle"><?php echo __('FAQ')?></h3>
    <p>
      <strong><?php echo __('Do I have to claim my site?');?></strong><br />
      <?php echo __("No, just in case you want to access your analytics.");?>
    </p>
    <p>
      <strong><?php echo __('Do I have to change the button code after claiming a site that already has the yiid button integrated?');?></strong><br />
      <?php echo __("No, claiming your site and using the button are completely non-dependent. We even start saving your analytics data from the moment on that you first integrate the button. It's just not accessable as long as your site isn't successfully claimed.");?>
    </p>
    <p>
      <strong><?php echo __('Do you offer other possibilities to claim my site, besides MicroIds?');?></strong><br />
      <?php echo __("Not at this time. Please contact us, if you're facing problems.");?>
    </p>
    <p><?php echo __("In you have any other questions, please contact");?> <a href="mailto: info@yiid.com">info@yiid.com</a></p><?php end_slot(); ?>
  <?php include_partial('global/graybox', array("twoCol" => true)); ?>
</div>
