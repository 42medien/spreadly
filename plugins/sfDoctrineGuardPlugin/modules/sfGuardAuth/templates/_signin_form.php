<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="sf_apply_apply_form">
  <table>
    <tbody>
      <?php echo $form ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <div class="clearfix">
			      <input type="submit" class="button positive" value="<?php echo __("Signin") ?>" />
				  </div>

          <div class="clearfix">
	          <?php $routes = $sf_context->getRouting()->getRoutes() ?>
	          <?php if (isset($routes['sf_guard_forgot_password'])): ?>
			        <?php echo link_to(__('Forgot your password?'), url_for('@sf_guard_forgot_password'), array('rel' => 'facebox', 'class' => 'button')); ?>
	          <?php endif; ?>

	          <?php if (isset($routes['sf_guard_register'])): ?>
	            &nbsp;
              <?php echo link_to(__('Want to register?'), url_for('@sf_guard_register'), array('rel' => 'facebox', 'class' => 'button')); ?>
	          <?php endif; ?>
	        </div>
        </td>
      </tr>
    </tfoot>
  </table>
</form>