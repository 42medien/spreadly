<?php if (count($pImages) > 0) {?>
<?php $i = 0; ?>
<?php foreach($pImages as $lImage) { ?>
	<div>
		<img id="meta-img-<?php echo $i;?>" src="<?php echo $lImage; ?>" width="200" height="100"/>
	</div>
<?php $i++; } ?>
<?php } else { ?>
	<div>
		<?php echo __('NO IMAGE'); ?>
	</div>
<?php } ?>