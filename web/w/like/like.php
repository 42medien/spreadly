<?php
require_once('inc/config.inc.php');

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
if (isset($_GET['short']) && !empty($_GET['short'])) {
  $pFullShortVersion = true;
} else {
  $pFullShortVersion = false;
}
if (isset($_GET['social']) && !empty($_GET['social'])) {
  $pSocialFeatures = true;
} else {
  $pSocialFeatures = false;
}


$pUserId = MongoSessionPeer::extractUserIdFromSession(LikeSettings::SF_SESSION_COOKIE);
$lSocialObjectArray = SocialObjectPeer::getDataForUrl($pUrl);
$lIsUsed = YiidActivityObjectPeer::actionOnObjectByUser($lSocialObjectArray['_id'], $pUserId);
$lSocialObjectArray = SocialObjectPeer::recalculateCountsRespectingUser($lSocialObjectArray, $lIsUsed);

// track visit
YiidStatsSingleton::trackVisit($pUrl);

$lPopupUrl = LikeSettings::JS_POPUP_PATH."?ei_kcuf=".time();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Yiid it! Button</title>
<script type="text/javascript" src="/js/widget/modules/Like.js"></script>
<script type="text/javascript">
  <?php echo printI18nJSObject($pType); ?>

  YiidWidget.init("<?php echo $pUrl; ?>", "<?php echo $pType; ?>", "<?php echo urlencode($_GET['title']); ?>", "<?php echo urlencode($_GET['description']); ?>", "<?php echo urlencode($_GET['photo']); ?>");
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

		  <?php if($lIsUsed === false) { ?>
		  <div id="container_like" class="left" <?php if($pUserId) { ?>onmouseover="YiidSlider.showClickElement();" onmouseout="YiidSlider.hideClickElement(event);"<?php } ?>>
	
	      <div class="light_bg_118 button_full_outer clearfix" id="normal_button">
	        <div id="service_area" class="left">
	          <div id="service_twitter_small_enabled" class="service_icon_small left"></div>
	          <div id="service_facebook_small_enabled" class="service_icon_small right"></div>
	          <div id="service_linkedin_small_enabled" class="service_icon_small left"></div>
	          <div id="service_google_small_enabled" class="service_icon_small right"></div>
	        </div>
	
	        <div class="hover_bg left" id="like_area">
	          <?php if($pFullShortVersion) { ?>
	            <a class="like_icon" title="<?php echo __("POS_BUTTON_TITLE", $pType); ?>" <?php if($pUserId) { ?>onclick="YiidWidget.doLike(1);return false;"<?php } else { ?>target="popup" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>', 1);return false;"<?php } ?>>&nbsp;</a>
	          <?php } else { ?>
	            <a class="like_text" title="<?php echo __("POS_BUTTON_TITLE", $pType); ?>" <?php if($pUserId) { ?>onclick="YiidWidget.doLike(1);return false;"<?php } else { ?>target="popup" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>', 1);return false;"<?php } ?>>
	              <?php echo __("POS_BUTTON_VALUE", $pType); ?><span class="like_icon">&nbsp;</span>
	            </a>
	          <?php } ?>
	        </div>
	
	        <div class="left <?php if($pUserId) { ?>hover_bg<?php } ?>" id="open_settings_icon_area" <?php if($pUserId) { ?>onclick="YiidSlider.slideIn(event); return false;"<?php } ?> style="display: none;">
	          <a id="slide_arrow_closed" class="open_settings_icon" title="<?php echo __("SETTINGS_TITLE"); ?>">&nbsp;</a>
	        </div>
	      </div>
	
	      <div id="settings_button" class="normal_button_area" style="display:none;">
	        <span id="settings_button_icon" class="left">&nbsp;</span>
	        <p class="left <?php echo (!$pFullShortVersion ? 'normal_space' : 'small_space') ?>" onclick="YiidSlider.slideOut(event);" title="<?php echo __("SETTINGS_TITLE"); ?>">
	          <?php if(!$pFullShortVersion) { ?><?php echo __("SETTINGS_VALUE"); ?><?php } ?>
	        </p>
	      </div>
	
	      <!-- Area to be slided -->
	      <div id="sliding_area" style="display:none;">
	        <div id="slide-box">
	          <table id="slide_table" cellpadding="0" cellspacing="0" class="left">
	            <tr id="slide-row">
	              <td id="settings-area" target="popup" title="Einstellungen" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>');"><a href="#100" class="settings_icon" id="settings">&nbsp;</a></td>
	            </tr>
	          </table>
	          <div class="hover_bg clearfix right" id="close_settings_icon_area" onclick="YiidSlider.slideOut(event); return false;">
	            <a id="slide_arrow_opened" class="close_settings_icon" title="<?php echo __("SETTINGS_TITLE"); ?>">&nbsp;</a>
	          </div>
	        </div>
	      </div>
	      <!-- Area to be slided -->
	
	    <?php } ?>
	
	  </div>

	  <div id="container_like_used" class="left" <?php if($lIsUsed === false) { ?>style="display: none;"<?php } ?>>
	    <div id="used_button" class="normal_button_area <?php echo (!$pFullShortVersion ? 'normal_space' : 'small_space') ?>_used" target="popup" onclick="return YiidUtils.openPopup('<?php echo $lPopupUrl; ?>');">
	
	      <?php if(is_numeric($lIsUsed)) { ?>
	
	        <?php if($pFullShortVersion) { ?>
	          <p class="like_icon" id="liked-text" title="<?php echo __('POS_BUTTON_ACTION_VALUE', $pType); ?>">&nbsp;</p>
	        <?php } else { ?>
	          <p id="liked-text" class="left"><?php echo __('POS_BUTTON_ACTION_VALUE', $pType); ?></p>
	        <?php } ?>
	
	      <?php } else { ?>
	
	        <?php if($pFullShortVersion) { ?>
	          <p class="like_icon" id="liked-text" title="<?php echo __('POS_BUTTON_ACTION_VALUE', $pType); ?>" style="display:none;">&nbsp;</p>
	        <?php } else { ?>
	          <p id="liked-text" class="left" style="display:none;"><?php echo __('POS_BUTTON_ACTION_VALUE', $pType); ?></p>
	        <?php } ?>
	
	      <?php } ?>
	    </div>
	  </div>
	
	  <!-- Text information -->
	  <div id="additional_text_area_like" class="left big_space_to_left" style="color: <?php echo $lFontcolor; ?>">
	    <?php if($lSocialObjectArray['urlerror']) { ?>
	      <p id="error-area" style="color: red; font-weight: bold; font-size: 11px;">INVALID URL: URL param must be valid or empty</p>
	    <?php } else { ?>
	      <p id="info-liked">
	        <span id="you-like" <?php if($lIsUsed != 1) { ?>style="display: none;" <?php } ?>><?php echo __('POS_TEXT_VALUE_1', $pType); ?></span>
	        <span class="counter"><?php echo $lSocialObjectArray['l_cnt']; ?></span><?php echo __('POS_TEXT_VALUE_2', $pType); ?>
	      </p>
	    <?php } ?>
	  </div>
	  <!-- /Text information -->
	</div>
  
  <?php if($pUserId && $pSocialFeatures) { ?>
    <?php $lLimit = $pFullShortVersion?'5':'7'; ?>
    <div id="friends" class="clearfix">
      <?php 
      /**
       * 1. Per Ajax Freundesbilder aus Action widget/load_friends in app widget holen. Dabei wird benötigt: SocialObjectId "so_id", UserId "u_id" und Limit "limit"
       * 2. Div mit ID #friends leeren und response.html aus 1. an diese Stelle setzen
       */
      ?>
      <?php for($i = 1; $i< $lLimit+1; $i++) {?>
        <div class="friends_image left">
          <img src="../../uploads/avatars/30x30/default.png" alt="Friend" title="Die Doris<?php echo $i;?>" />
        </div>
      <?php }?>
    </div>
  <?php } ?>
  
</div>

</body>
</html>
