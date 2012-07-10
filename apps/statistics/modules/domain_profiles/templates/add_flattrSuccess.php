<section class="content-publish">
  <section class="container_12">
    <div id="tracking_url" class="content-box">
      <h2><?php echo __("Add flattr support"); ?></h2>

      <p><?php echo __("To enable flattr support for your domain %s, you have to verify your account.", array("%s" => $domainProfile->getDomain())); ?></p>

      <form action="" method="post">
        <label class="inputlabel">
          <input type="text" class="inputfield" placeholder="enter your flattr username" style="width: 500px" name="flattr_account" value="<?php echo $domainProfile->getFlattrAccount() ?>" />
        </label>
        <input class="blue-btn" type="submit" value="Speichern" />
      </form>

      <p>
        <span class="error"><?php echo __($error); ?></span>
        <span class="info"><?php echo __($info); ?></span>
      </p>

      <p><?php echo __("To disable flattr, please remove the username from the field above and press 'save'"); ?></p>

      <p><?php echo link_to(__("Back to the domain-page"), "domain_profiles/index"); ?></p>
    </div>
  </section>
</section>