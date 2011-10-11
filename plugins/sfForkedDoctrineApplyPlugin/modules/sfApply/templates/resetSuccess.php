<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<?php slot('content') ?>
<div class="sf_apply sf_apply_reset">
<form method="post" action="<?php echo url_for("sfApply/reset") ?>" name="sf_apply_reset_form" id="sf_apply_reset_form">
<p>
Vielen Dank für die Bestätigung Ihrer eMail-Adresse. Sie können jetzt Ihr Passwort ändern. Klicken Sie dazu den Button “Passwort neu setzen”.</p>
<p>
Thanks for confirming your email address. You may now change your password using the button “Reset my password” below.
</p>
	<table>
		<?php echo $form ?>
	</table>
<ul>
<li>
<button type="submit"><span><?php echo __("Reset My Password", array(), 'sfForkedApply') ?></span></button>
<?php echo __("or", array(), 'sfForkedApply') ?>
<?php echo link_to('<span>'.__('Cancel', array(), 'sfForkedApply').'</span>', 'sfApply/resetCancel') ?>
</li>
</ul>
</form>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>