<?php $i = 0; ?>
<?php foreach($pImages as $lImage) { ?>
	<div>
		<img id="img-<?php echo $i;?>" src="<?php echo $lImage; ?>" width="200px" height="100px"/>
	</div>
<?php $i++; } ?>