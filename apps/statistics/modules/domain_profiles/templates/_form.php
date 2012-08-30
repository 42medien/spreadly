
	<form action="<?php echo url_for('domain_profiles/create'); ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> id="new_domain_profile_form">
	<?php echo $form->renderHiddenFields(false); ?>
	<div class="clearfix nameselection-bar">
	<label id="http-sel">
		<?php echo $form['protocol']->render(array('class' => 'custom-select')); ?>
	</label>
		<label><?php echo $form['url']->render(array('class' => 'nameinput')); ?></label>
		<input type="submit" class="blue-btn" name="" value="<?php echo __('Save', null, 'widget');?>" />
<div id="add-url-error" class="error" style="display:none;"></div>
	</div>
	</form>
