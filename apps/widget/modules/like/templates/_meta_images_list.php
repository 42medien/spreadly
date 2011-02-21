<?php
if (count($pImages) > 0) {
  $i = 0;
  foreach($pImages as $lImage) {
?>
	<div>
		<img id="meta-img-<?php echo $i;?>" src="<?php echo $lImage; ?>" width="80" />
	</div>
<?php
    $i++;
  }
} else {
?>
	<div id="no-meta-img" style="width:80px;">
		<?php echo __('No Image'); ?>
	</div>
<?php } ?>