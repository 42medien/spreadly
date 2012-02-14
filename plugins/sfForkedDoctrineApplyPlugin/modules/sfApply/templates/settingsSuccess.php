<?php slot('sf_apply_login') ?>
<?php use_stylesheets_for_form( $form ) ?>
<?php end_slot() ?>
<?php use_helper("I18N") ?>


<div class="sf_apply sf_apply_settings">
<h2><?php echo __("Persönliche Informationen") ?></h2>
<?php if(isset($pSettingssuccess) && $pSettingssuccess == true) {?>
	<h3><?php echo __('Ihre Daten wurden gespeichert!'); ?></h3>
<?php } ?>
<form method="post" action="<?php echo url_for("sfApply/settings") ?>" name="sf_apply_settings_form" id="sf_apply_settings_form">
<table>
	<?php echo $form ?>
  <tfoot>
		<tr>
			<td colspan="2" id="signup-button-row">
				<button type="submit" class="blue-btn alignright"><?php echo __("Save") ?></button>
				<?php echo link_to(__("Abbrechen"), sfConfig::get('app_sfApplyPlugin_after', '@homepage'), array('class' => 'blue-btn alignright')) ?>
			</td>
		</tr>
	</tfoot>
</table>



</form>




<h2><?php echo __("Passwort ändern") ?></h2>
<?php if(isset($pPasswordsuccess) && $pPasswordsuccess == true) {?>
	<h3><?php echo __('Ihr neues Passwort wurde gespeichert!'); ?></h3>
<?php } ?>
<form method="post" action="<?php echo url_for("sfApply/settings_reset") ?>" name="sf_apply_reset_form" id="sf_apply_settings_reset_form">
<?php //echo __('Click the button below to change your password.'); ?>
<?php	//$confirmation = sfConfig::get( 'app_sfForkedApply_confirmation' ); ?>
<table>
	<?php echo $resetform;?>
	<?php //echo __('For security reasons, you will receive a confirmation email containing a link allowing you to complete the password change.') ?>
  <tfoot>
		<tr>
			<td colspan="2" id="signup-button-row">
				<button type="submit" class="blue-btn alignright"><?php echo __("Save") ?></button>
				<?php echo link_to(__("Abbrechen"), sfConfig::get('app_sfApplyPlugin_after', '@homepage'), array('class' => 'blue-btn alignright')) ?>
			</td>
		</tr>
	</tfoot>

</table>

</form>

</div>