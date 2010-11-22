<?php if($domain_profile != null && $domain_profile->isVerified()): ?>
  <h2><?php echo $domain_profile->getDomain() ?> wurde verifiziert</h2>
  <p><a href="#" class="button toggle_new_domain_profile">Close</a></p>
<?php else: ?>
  <h2><?php echo $domain_profile->getDomain() ?> konnte nicht verifiziert werden</h2>

  <?php $token = '&lt;meta name=\'microid\' content=\''.$domain_profile->getVerificationToken().'\' /&gt;'; ?>

  <p>
    <input type="text" value="<?php echo $token ?>" onfocus="this.select();"/>
  </p>

  <p><?php echo link_to($domain_profile->getUrl().' erneut verifizieren', 'verify', array('id' => $domain_profile->getId()), array('class' => 'button positive inline verify_domain_profile')) ?></p>
  

  <p><a href="#" class="button toggle_new_domain_profile">Später nochmal versuchen</a></p>
<?php endif; ?>
