<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form( $form ) ?>
<?php
  // Override the login slot so that we don't get a login prompt on the
  // apply page, which is just odd-looking. 0.6
?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>


		<div class="sf_apply sf_apply_apply alignleft">
		  <h2 class="verifytitle"><?php echo __("Login") ?></h2>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="sf_apply_apply_form">
  <table>
    <tbody>
      <?php echo $signinform ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
			      <button type="submit" id="signin-button" class="blue-btn alignright"><span><?php echo __("Signin") ?></span></button>
      </tr>
      <tr>
      	<td colspan="2">
          <div class="clearfix alignright">
	          <?php $routes = $sf_context->getRouting()->getRoutes() ?>
	          <?php if (isset($routes['sf_guard_forgot_password'])): ?>
			        <?php echo link_to(__('Forgot your password?'), url_for('@sf_guard_forgot_password')); ?>
	          <?php endif; ?>

	          <?php if (isset($routes['sf_guard_register'])): ?>
	            &nbsp;
              <?php echo link_to(__('Want to register?'), url_for('@sf_guard_register')); ?>
	          <?php endif; ?>
	        </div>
        </td>
      </tr>
    </tfoot>
  </table>
</form>
</div>



		<div class="sf_apply sf_apply_apply alignright">
		  <h2 class="verifytitle"><?php echo __("Registrierung") ?></h2>

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
