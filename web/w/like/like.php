<?php
require_once('inc/config.inc.php');

session_name("yiid_widget");
session_set_cookie_params(time()+17776000, "/", LikeSettings::COOKIE_DOMAIN);
session_start();
header('P3P: CP="DSP LAW"');
header('Pragma: no-cache');
header('Cache-Control: private, no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

require_once('inc/WidgetUtils.php');
require_once('inc/i18n.php');

if (isset($_GET['url']) && !empty($_GET['url'])) {
  $pUrl = urlencode(UrlUtils::skipTrailingSlash($_GET['url']));
} else {
  $pUrl = urlencode(UrlUtils::skipTrailingSlash($_SERVER['HTTP_REFERER']));
}
if (isset($_GET['type']) && !empty($_GET['type'])) {
  $pType = $_GET['type'];
} else {
  $pType = "like";
}
if (isset($_GET['color']) && !empty($_GET['color'])) {
  $lFontcolor = urldecode($_GET['color']);
} else {
  $lFontcolor = "#000000";
}

$pUserId = MongoSessionPeer::extractUserIdFromSession(LikeSettings::SF_SESSION_COOKIE);
$lSocialObjectArray = SocialObjectPeer::getDataForUrl($pUrl);
$lIsUsed = YiidActivityObjectPeer::actionOnObjectByUser($lSocialObjectArray['_id'], $pUserId);
$lSocialObjectArray = SocialObjectPeer::recalculateCountsRespectingUser($lSocialObjectArray, $lIsUsed);

$lPopupUrl = LikeSettings::JS_POPUP_PATH."?ei_kcuf=".time();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Yiid it! Button</title>
<script type="text/javascript" src="/js/widget/QuicksilverLike.min.js"></script>
<script type="text/javascript">
  <?php echo printI18nJSObject($pType); ?>

  YiidWidget.init("<?php echo $pUrl; ?>", "<?php echo $pType; ?>", "<?php echo urlencode($_GET['title']); ?>", "<?php echo urlencode($_GET['description']); ?>", "<?php echo urlencode($_GET['photo']); ?>");
  YiidWidget.aPopupPath = "<?php echo $lPopupUrl;  ?>";
  YiidRequest.aLikeAction = "<?php echo LikeSettings::JS_LIKE_PATH; ?>";
  YiidRequest.aDislikeAction = "<?php echo LikeSettings::JS_DISLIKE_PATH; ?>";
  YiidCookie.aDomain = "<?php echo LikeSettings::COOKIE_DOMAIN; ?>";
</script>
<link rel="stylesheet" href="/css/widget/YiidWidget.css" type="text/css" media="screen, projection" />
</head>
<body>
<?php if($lIsUsed === false) { ?>
<div id="container_like" <?php if($pUserId) { ?>onmouseover="YiidSlider.showClickElement();" onmouseout="YiidSlider.hideClickElement(event);"<?php } ?>>
  <!-- Common button area -->
  <div id="normal_button" class="rounded_corners normal_button_area">
    <p class="left" id="thumb_up" title="<?php echo __("POS_BUTTON_TITLE", $pType); ?>" <?php if($pUserId) { ?>onclick="YiidWidget.doLike(1);"<?php } else { ?>target="popup" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>', true);"<?php } ?>><?php echo __("POS_BUTTON_VALUE", $pType); ?> <a class="thumb" id="thumb_up_icon">&nbsp;</a></p>
  </div>

  <div id="settings_button" class="rounded_corners normal_button_area" style="display:none;">
    <p class="left" onclick="YiidSlider.slide(event);" title="<?php echo __("SETTINGS_TITLE"); ?>"><?php echo __("SETTINGS_VALUE"); ?></p>
  </div>
  <!-- /Common button area -->

  <!-- Area to be slided -->
  <div class="rounded_corners" id="sliding-area" style="display:none;">
    <div id="slide-box">
      <table id="slide-table" cellpadding="0" cellspacing="0">
        <tr id="slide-row">
          <td id="settings-area" target="popup" title="<?php echo __("SETTINGS_TITLE"); ?>" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>');"><a href="#100" class="favicon" id="settings">&nbsp;</a></td>
        </tr>
      </table>
    </div>
  </div>
  <!-- Area to be slided -->

  <!-- Slider Icon -->

  <div class="dark_grey rounded_corners slider_area closed" id="slide-arrow" onclick="YiidSlider.slide(event); return false;">
    <a href="#200">&nbsp;</a>
  </div>
  <!-- /Slider Icon -->

</div>
<?php } ?>
<div id="container_like_used" <?php if($lIsUsed === false) { ?>style="display: none;"<?php } ?>>
  <div id="settings_button" class="rounded_corners normal_button_area" target="popup" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>');">
    <a class="normal_icon left yiid_logo">&nbsp;</a>
      <?php if(is_numeric($lIsUsed)) { ?>
        <p id="liked-text" class="left"><?php echo __('POS_BUTTON_ACTION_VALUE', $pType); ?></p>
      <?php } elseif ($lIsUsed == -1) { ?>
        <p id="disliked-text" class="left"><?php echo __('NEG_BUTTON_ACTION_VALUE', $pType); ?></p>
      <?php } else { ?>
        <p id="liked-text" class="left" style="display:none;"><?php echo __('POS_BUTTON_ACTION_VALUE', $pType); ?></p>
      <?php } ?>
    </div>
</div>

<!-- Text information -->
<div id="additional_text_area_like" style="color: <?php echo $lFontcolor; ?>">
    <p id="info-liked">
      <span id="you-like" <?php if($lIsUsed != 1) { ?>style="display: none;" <?php } ?>><?php echo __('POS_TEXT_VALUE_1', $pType); ?></span>
      <span class="counter"><?php echo $lSocialObjectArray['l_cnt']; ?></span><?php echo __('POS_TEXT_VALUE_2', $pType); ?>
    </p>
</div>
<!-- /Text information -->
</body>
</html>
