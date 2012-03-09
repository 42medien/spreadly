<a href="#" id="close-settings-link">X</a>
<div id="edit-img-container">
	<h3><?php echo __('Select the image that you want to show into the button after sharing');  ?></h3>
	<div id="select-img-list">
		<?php foreach($pOis as $lIdentity) {?>
			<?php //var_dump($lIdentity->getPhoto()); ?>
			<?php if($lIdentity->getPhoto() != NULL) { ?>
				<a href="<?php echo url_for('settings/select_image?oid='.$lIdentity->getId()); ?>" class="select-profile-img-link <?php if($lIdentity->getUseAsAvatar() == true) { echo 'selected'; } ?>"><img height="20px" width="20" src="<?php echo $lIdentity->getPhoto(); ?>" /></a>
			<?php } ?>
		<?php } ?>
	</div>
</div>