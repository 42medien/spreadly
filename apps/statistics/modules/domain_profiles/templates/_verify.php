<?php if($domain_profile != null && $domain_profile->isPending()): ?>
  <h2>Verify <?php echo $domain_profile->getDomain() ?></h2>
  <p>Sie müssen nun folgenden Code im &lt;head&gt;-Bereich der Indexseite von <strong><?php echo $domain_profile->getDomain() ?></strong> einfügen.</p>

  <?php $token = '&lt;meta name=\'microid\' content=\''.$domain_profile->getVerificationToken().'\' /&gt;'; ?>

  <p>
    <input type="text" value="<?php echo $token ?>" onfocus="this.select();"/>
  </p>

  <p>Sobald Sie das erledigt haben, müssen Sie die Seite verifizieren. Klicken Sie dazu auf folgenden Button:</p>

  <p><?php echo link_to($domain_profile->getUrl().' verifizieren', 'verify', array('id' => $domain_profile->getId()), array('class' => 'button positive inline verify_domain_profile')) ?></p>
<?php else: ?>
  <h2>Diese Website ist bereits verifiziert.</h2>
  <p><a href="#" class="button toggle_new_domain_profile">Close</a></p>
<?php endif; ?>
