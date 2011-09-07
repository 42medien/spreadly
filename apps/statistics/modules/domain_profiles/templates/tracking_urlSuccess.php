<?php slot('content') ?>

<div id="tracking_url" class="content-box">
  <h2><?php echo __("Add a tracking url"); ?></h2>

  <p><?php echo __("Here you can add an additional tracking code for the domain: %s", array("%s" => $domainProfile->getDomain())); ?></p>

  <p><?php echo __("Note: This feature is still in Beta! If you get an error or find a bug, please use our feedback tool to send us a short report about the failure"); ?></p>

  <form action="" method="POST">
    <input type="text" placeholder="enter a valid url and don't forget the 'http://'" style="width: 500px" name="tracking_url" value="<?php echo $domainProfile->getTrackingUrl() ?>" />

    <input type="submit" />
  </form>

  <p>
  <span class="error"><?php echo __($error); ?></span>
  <span class="info"><?php echo __($info); ?></span>
  </p>

  <p><?php echo __("To disable the tracking for your domain, please remove the url from the field above and press 'save'"); ?></p>

  <p><?php echo link_to(__("Back to the domain-page"), "domain_profiles/index"); ?></p>
</div>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>