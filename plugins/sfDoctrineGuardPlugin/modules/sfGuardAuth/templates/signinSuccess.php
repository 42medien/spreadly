<?php use_helper('I18N') ?>

<div class="formbox" id="guard_signin_area">
	<h2><?php echo __('&raquo; Signin') ?></h2>

	<?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
</div>