<?php include("buttonheader.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>spread.ly</title>
  <script type="text/javascript" src="/js/100_main/include/Like-<?php echo LikeSettings::RELEASE_NAME; ?>.min.js"></script>
  <script type="text/javascript">
  <?php echo printI18nJSObject($pType); ?>

  YiidWidget.init("<?php echo urlencode($pUrl); ?>", "<?php echo $pType; ?>", "<?php echo urlencode($pTitle); ?>", "<?php echo urlencode($pDescription); ?>", "<?php echo urlencode($pPhoto); ?>", "<?php echo urlencode($lClickback); ?>", "<?php echo urlencode($pTags); ?>");
  YiidWidget.aPopupPath = "<?php echo $lPopupUrl;  ?>";

  <?php if ($lShowFriends) { ?>
    YiidFriends.aGetAction = "<?php echo LikeSettings::JS_GETFRIENDS_PATH; ?>";
    YiidFriends.init("<?php echo $lSocialObjectArray['_id'.""] ?>", "<?php echo $pUserId; ?>", "<?php echo $lLimit; ?>")
  <?php } ?>

</script>
<link rel="stylesheet" href="/css/widget/Button.css" type="text/css" media="screen, projection" />
</head>
<body>

  <a href="#" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>');">i like this really</a>

</body>
</html>
