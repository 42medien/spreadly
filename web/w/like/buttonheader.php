<?php
include('inc/config.inc.php');
include('inc/WidgetUtils.php');
include('inc/i18n.php');

session_name("yiid_widget");
session_set_cookie_params(time()+17776000, "/", LikeSettings::COOKIE_DOMAIN);
session_start();
header('P3P: CP="DSP LAW"');
header('Pragma: no-cache');
header('Cache-Control: private, no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

// <Check Params>
if (isset($_GET['url']) && !empty($_GET['url'])) {
  $pUrl = urldecode($_GET['url']);
} else {
  $pUrl = urldecode($_SERVER['HTTP_REFERER']);
}
if (isset($_GET['social']) && !empty($_GET['social'])) {
  $pSocialFeatures = true;
} else {
  $pSocialFeatures = false;
}

$pTitle = urldecode($_GET['title']);
$pPhoto = urldecode($_GET['photo']);
$pDescription = urldecode($_GET['description']);
$pTags = trim(urldecode($_GET['tags']));
// </Check Params>

$lClickback = WidgetUtils::extractClickback($pUrl, $_SERVER['HTTP_REFERER']);
$pUserId = WidgetUtils::extractUserIdFromSession(LikeSettings::SF_SESSION_COOKIE);
$lSocialObjectArray = WidgetUtils::getDataForUrl($pUrl);

// <Deal>
$lActiveDeal = WidgetUtils::getActiveDeal($pUrl, $pTags);
if (!$lActiveDeal || WidgetUtils::actionOnHostByUser($pUserId, $lActiveDeal)) {
  $lActiveDeal = null;
}

$lActivityObject = WidgetUtils::getYiidActivity($lSocialObjectArray['_id'], $pUserId, $lActiveDeal);
// </Deal>

$pButtonClass = "";
if ($lActivityObject) {
  $pButtonClass = "disabled";
} elseif ($lActiveDeal) {
  $pButtonClass = "deal";
}

$lSocialObjectArray = WidgetUtils::recalculateCountsRespectingUser($lSocialObjectArray, $lIsUsed);

$lShowFriends = false;
$lLimit = 6;
if($pUserId && $pSocialFeatures && $lSocialObjectArray['_id']) {
  $lShowFriends = true;
  $lLimit = $pFullShortVersion?6:8;
}

WidgetUtils::trackUser($pUrl, $lClickback, $pUserId);

$lPopupUrl = LikeSettings::JS_POPUP_PATH."?ei_kcuf=".time()."&title=".urlencode($pTitle)."&description=".urlencode($pDescription)."&photo=".urlencode($pPhoto)."&tags=".urlencode($pTags)."&url=".urlencode($pUrl);