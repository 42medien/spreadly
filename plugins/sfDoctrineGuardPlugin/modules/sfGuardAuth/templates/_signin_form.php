<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" id="sf_apply_apply_form">
  <table>
    <tbody>
      <?php echo $form ?>
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
<script type="text/javascript">
jQuery('.colorbox').colorbox({
	opacity: '0.8',
	title: true
});
</script>