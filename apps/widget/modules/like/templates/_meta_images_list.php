<?php
if (count($pImages) > 0) {
  $i = 0;
  foreach($pImages as $lImage) {
?>
	<div>
		<img id="meta-img-<?php echo $i;?>" src="<?php echo $lImage; ?>" width="120px" />
	</div>
<?php
    $i++;
  }
} ?>
<div>
	<img id="meta-img-1337" src="<?php echo image_path("/img/share/default.png", true); ?>" width="120px" />
</div>