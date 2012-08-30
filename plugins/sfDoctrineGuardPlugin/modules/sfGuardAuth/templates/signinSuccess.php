<?php use_helper('I18N') ?>

<section class="content-publish">
	<section class="container_12">
		<div class="formbox" id="guard_signin_area">
			<h2><?php echo __('Signin') ?></h2>
			<?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
		</div>


				<?php include_partial('global/spreadly_references');?>
	</section>
</section>
