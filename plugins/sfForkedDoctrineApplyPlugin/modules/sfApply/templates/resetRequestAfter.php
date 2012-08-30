<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<?php slot('content') ?>
<div class="sf_apply_notice">
<p>Aus Sicherheitsgründen haben wir Ihnen eine Bestätigungsmail an die hinterlegte Adresse gesendet. Bitte klicken Sie darin den Link, um Ihr Passwort zu ändern. Sollten Sie die Bestätigungsmail “Spreadly-E-Mail-Adresse” nicht gleich finden, suchen Sie bitte auch in den Ordnern “Spam” und “Bulk”.
</p>
<p>
For security reasons, a confirmation message “Spreadly-E-Mail-Adresse”
has been sent to the email address associated with this account. Please check your
email for that message. You will need to click on a link provided in that email in order to change your password. If you do not see the message, be sure to check your "spam" and "bulk" email folders.
</p>
<?php include_partial('sfApply/continue') ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
