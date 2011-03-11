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

i18n.init({
	"like_success_message": "<?php echo __("Like successfully sent!");?>",
	"like_error_message": "<?php echo __("Something went wrong! Check your selected services and try again!");?>"
});
WidgetLikeForm.init();
jQuery(".likecheckbox").custCheckBox();