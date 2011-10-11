<?php use_helper('I18N') ?>

<?php slot('content') ?>
  <div class="sf_apply_notice">
    <p>
Sie haben Ihren Zugang erfolgreich bestätigt und sind jetzt eingeloggt.<br>
Thank you for confirming your account! You are now logged into the site.
    </p>
    <?php include_partial('sfApply/continue') ?>
  </div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
