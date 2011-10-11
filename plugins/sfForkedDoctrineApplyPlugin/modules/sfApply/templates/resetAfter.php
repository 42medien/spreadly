<?php use_helper('I18N') ?>

<?php slot('content') ?>
<div class="sf_apply_notice">
<p>
Ihr neues Passwort ist nun gültig und Sie sind jetzt eingeloggt. Nutzen Sie ab jetzt immer Ihr neues Passwort.<br>
Your password has been successfully reset. You are now logged in to this site. In the future, be sure to log in with your new password.
</p>
<?php include_partial('sfApply/continue') ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
