<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="sf_apply_apply_form">
  <table>
    <tbody>
      <?php echo $form ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <div class="clearfix right">
			      <button type="submit" class="button right"><span><?php echo __("Signin") ?></span></button>
				  </div>

      </tr>
      <tr>
      	<td colspan="2">
          <div class="clearfix right">
	          <?php $routes = $sf_context->getRouting()->getRoutes() ?>
	          <?php if (isset($routes['sf_guard_forgot_password'])): ?>
			        <?php echo link_to(__('Forgot your password?'), url_for('@sf_guard_forgot_password'), array('class' => 'colorbox')); ?>
	          <?php endif; ?>

	          <?php if (isset($routes['sf_guard_register'])): ?>
	            &nbsp;
              <?php echo link_to(__('Want to register?'), url_for('@sf_guard_register'), array('class' => 'colorbox')); ?>
	          <?php endif; ?>
	        </div>
        </td>
      </tr>
    </tfoot>
  </table>
</form>