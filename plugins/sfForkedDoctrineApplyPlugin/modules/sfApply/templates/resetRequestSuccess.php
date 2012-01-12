<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form( $form ) ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<section class="content-publish">
	<section class="container_12">
		<div class="sf_apply sf_apply_reset_request">

		<h2 class="green_style"><?php echo __("Passwort zurücksetzen", array(), 'sfForkedApply') ?></h2>
		<form method="POST" action="<?php echo url_for('sfApply/resetRequest') ?>" name="sf_apply_reset_request" id="sf_apply_reset_request">

		<p>
			<?php echo __('Username oder Passwort vergessen? Kein Problem! Einfach Benutzername oder Email-Adresse eingeben und bestätigen und wir schicken ihnen eine Email mit ihrem Benutzernamen und einem Link zum Zurücksetzen des Passworts.', array(), 'sfForkedApply') ?>
		</p>

		<table>
		  <tbody>
		    <?php echo $form ?>
		  </tbody>
		  <tfoot>
		    <tr>
		      <td id="forgot-pw-button-row" colspan="2">
		        <button class="blue-btn alignright" type="submit"><span><?php echo __("Passwort zurücksetzen", array(), 'sfForkedApply') ?></span></button>
		        <?php echo link_to('<span>'.__("Abbrechen", array(), 'sfForkedApply').'</span>', sfConfig::get('app_sfApplyPlugin_after', '@homepage'), array('class' => 'blue-btn alignright')) ?>
		      </td>
		    </tr>
		  </tfoot>
		</table>
		</form>
		</div>
		<?php include_partial('global/spreadly_references');?>
	</section>
</section>
