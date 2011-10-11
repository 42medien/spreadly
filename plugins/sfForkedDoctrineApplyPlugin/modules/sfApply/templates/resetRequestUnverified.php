<?php use_helper('I18N') ?>
<?php slot('content') ?>
<div class="sf_apply_notice">
<p>
Sie müssen Ihren Zugang bestätigen, bevor Sie sich einloggen können. Falls nötig, können Sie Ihr Passwort neu setzen. Wir haben Ihnen die eMail zur Verifizierung “Spread.ly -Zugang zu bestätigen / account to be confirmed” erneut gesendet. Bitte folgen Sie der Anleitung in dieser eMail und bestätigen Sie Ihren Zugang. Falls Sie die eMail nicht gleich finden, suchen Sie bitte auch in den Ordnern “Spam” und “Bulk”.
</p>
<p>
That account was never verified. You must verify the account before you can log in or, if
necessary, reset the password. We have resent your verification email, which contains
instructions to verify your account. If you do not see that email, please be sure to check 
your "spam" or "bulk" folder.
</p>
<?php include_partial('sfApply/continue') ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
