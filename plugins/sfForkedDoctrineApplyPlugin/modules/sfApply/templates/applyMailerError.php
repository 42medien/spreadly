<?php use_helper('I18N') ?>
<?php slot('content') ?>
  <div class="sf_apply_notice">
    <p>
      Ein Fehler ist aufgetreten. Das hätte nicht passieren dürfen. Bitte versuchen Sie es später noch einmal. Vielen Dank und Entschuldigung!
    </p>
    <p>
      An error took place during the email delivery process. Please try again later. Thank you and sorry!
    </p>
    <?php include_partial('sfApply/continue') ?>
  </div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
