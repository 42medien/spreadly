<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Yiid it! Button</title>
<script type="text/javascript" src="/js/widget/modules/Like.js"></script>
<script type="text/javascript">
  <?php echo printI18nJSObject($pType); ?>

  YiidWidget.init("<?php echo urlencode($pUrl); ?>", "<?php echo $pType; ?>", "<?php echo urlencode($pTitle); ?>", "<?php echo urlencode($pDescription); ?>", "<?php echo urlencode($pPhoto); ?>", "<?php echo urlencode($lClickback); ?>");
  YiidWidget.aPopupPath = "<?php echo $lPopupUrl;  ?>";
  YiidRequest.aLikeAction = "<?php echo LikeSettings::JS_LIKE_PATH; ?>";
  YiidRequest.aDislikeAction = "<?php echo LikeSettings::JS_DISLIKE_PATH; ?>";
  YiidCookie.aDomain = "<?php echo LikeSettings::COOKIE_DOMAIN; ?>";
</script>
<link rel="stylesheet" href="/css/widget/Button.css" type="text/css" media="screen, projection" />
</head>
<body>
  <div id="container">
    <div class="clearfix">
      <div id="container_like" class="left">
        <div class="light_bg_118 button_full_outer clearfix" id="normal_button">
          <div id="service_area" class="left">
            <div id="service_twitter_small_enabled" class="service_icon_small left"></div>
            <div id="service_facebook_small_enabled" class="service_icon_small right"></div>
            <div id="service_linkedin_small_enabled" class="service_icon_small left"></div>
            <div id="service_google_small_enabled" class="service_icon_small right"></div>
          </div>

          <div class="hover_bg left" id="like_area">
            <a class="like_text" title="<?php echo __("POS_BUTTON_TITLE", $pType); ?>" target="popup" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>');return false;">
              Deal<span class="like_icon">&nbsp;</span>
            </a>
          </div>
        </div>
      </div>

      <div id="additional_text_area_like" class="left big_space_to_left">
        <?php echo $lActiveDeal['desc'] ?>
      </div>
    </div>
  </div>
</body>
</html>