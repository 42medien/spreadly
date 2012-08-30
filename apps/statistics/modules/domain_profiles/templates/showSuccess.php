<div class="content-box">
  <?php include_partial('verify', array('domain_profile' => $domain_profile)) ?>

  <p><a href="<?php echo url_for('domain_profiles/edit?id='.$domain_profile->getId()) ?>" class="button">Vertippt?</a></p>
</div>