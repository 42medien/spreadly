<form action="like/save" name="widget-like-form" method="POST">
<?php $lImages = $pYiidMeta->getImages();?>

<input type="hidden" name="like[img]" id="like-img-value" value="<?php echo $lImages[0]; ?>" />
<input type="hidden" name="like[title]" value="<?php echo $pYiidMeta->getTitle(); ?>" />
<input type="hidden" name="like[description]" value="<?php echo $pYiidMeta->getDescription(); ?>" />

<div class="whtboxtop">
	<div class="rcor">
		<?php foreach($pIdentities as $lIdentity) {?>
			<input type="checkbox" name="like[oi][<?php echo $lIdentity->getCommunity()->getName(); ?>]" value="<?php echo $lIdentity->getId(); ?>" /><label><?php echo $lIdentity->getCommunity()->getName(); ?></label>
		<?php } ?>
	</div>
</div>
<div class="wht-contentbox clearfix">

<!-- "previous page" action -->
<!-- root element for scrollable -->

<div class="scrollable-content clearfix">
	<div class="scrollable" id="myscroll">
	   <!-- root element for the items -->
	   <div class="items" id="scroll-meta-images">
	   	<?php include_partial('like/meta_images_list', array('pImages' => $lImages)); ?>
	   </div>
	</div>
	<!-- "next page" action -->
	<div id="scroll-button-area" <?php echo (count($pYiidMeta->getImages()) <= 1)? "style='display:none;'":"";?>>
		<a class="prev browse left slide-back-link" id="slide-back-link"></a>
		<a class="next browse left slide-next-link" id="slide-next-link"></a>
		<span id="img-counter">1</span>/<span id="img-number"><?php echo count($pYiidMeta->getImages()); ?></span>
	</div>
</div>
<div>
	TITLE: <?php echo $pYiidMeta->getTitle(); ?>
</div>
<div>
	DESCRIPTION: <?php echo $pYiidMeta->getDescription(); ?>
</div>


<textarea rows="2" cols="2" name="like[text]"></textarea>
<input type="submit" value="Spread It" />

</div>
<div class="whtboxbot"><span></span></div>
</form>