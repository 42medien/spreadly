<?php if($pImgCount == 0) { ?>
 LikeImage.get("<?php echo $pUrl;?>");
<?php } else if ($pImgCount == 1) { ?>
	WidgetLikeForm.setImageValue(LikeImage.getImgPath(0));
	LikeImageCounter.hide();
<?php } else { ?>
	LikeImageScroller.init(true);
  LikeImageCounter.init("<?php echo $pImgCount; ?>");
  LikeImageCounter.show();
  LikeImageScroller.onScroll();
<?php } ?>