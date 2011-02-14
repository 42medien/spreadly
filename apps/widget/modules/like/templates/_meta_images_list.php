<?php if (count($pImages) > 0) {?>
<?php $i = 0; ?>
<?php foreach($pImages as $lImage) { ?>
	<div>
		<img id="meta-img-<?php echo $i;?>" src="<?php echo $lImage; ?>" width="200" height="100"/>
	</div>
<?php $i++; } ?>
<?php } else { ?>
	<div id="no-meta-img" style="width:200px; height: 100px; border: 1px solid red;">
		<?php echo __('NO IMAGE'); ?>
	</div>
<?php } ?>