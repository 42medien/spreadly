<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form( $form ) ?>
<?php
  // Override the login slot so that we don't get a login prompt on the
  // apply page, which is just odd-looking. 0.6
?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>

		<div class="sf_apply sf_apply_apply">
		  <h2 class="verifytitle"><?php echo __("Registrierung", array(), 'sfForkedApply') ?></h2>

		  <form method="post" action="<?php echo url_for('sfApply/apply') ?>" name="sf_apply_apply_form" id="sf_apply_apply_form">
		  <table>
		    <tbody>
		      <?php echo $form ?>
		    </tbody>
		    <tfoot>
		      <tr>
		        <td colspan="2" id="signup-button-row">
		            <button type="submit" class="blue-btn alignright"><?php echo __("Weiter", array(), 'sfForkedApply') ?></button>
		            <?php echo link_to(__("Abbrechen", array(), 'sfForkedApply'), sfConfig::get('app_sfApplyPlugin_after', '@homepage'), array('class' => 'blue-btn alignright')) ?>
		        </td>
		      </tr>
		    </tfoot>
		  </table>

		  </form>
		</div>

		<?php //include_partial('global/spreadly_references');?>
