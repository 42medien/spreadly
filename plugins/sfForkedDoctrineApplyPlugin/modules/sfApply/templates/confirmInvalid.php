<?php use_helper('I18N') ?>

<?php slot('content') ?>
  <div class="sf_apply_notice">
<p>
Der Bestätigungscode ist ungültig.<br>
That confirmation code is invalid.
  </p><p>
Falls Sie Ihren Zugang bereits bestätigt haben, gehen Sie direkt zum Login um sich einzuloggen.<br>
This may be because you have already confirmed your account. If so,
  just click on the "Log In" button to log in.
  </p><p>
Weitere Problemlösungen:<br>
Other possible explanations:
  </p><p>
  1. 
Bitte überprüfen Sie, ob Sie beim Kopieren der URL auch die gesamte URL tatsächlich eingefügt haben.<br>
If you copied and pasted the URL from
  your confirmation email, please make sure you did so correctly and
  completely.
  </p><p>
  2.
Haben Sie die eMail zur Betsätigung Ihres Zugangs bereits vor längerer Zeit erhalten? Dann wurde der bis jetzt ungenutzte Zugang automatisch aus dem System gelöscht. Bitte registrieren Sie sich erneut.<br>
 If you received this confirmation email a long time ago
  and never confirmed your account, it is possible that your account has
  been purged from the system. In that case, you should simply apply
  for a new account.
  </p>
  <?php include_partial('sfApply/continue') ?>
  </div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
