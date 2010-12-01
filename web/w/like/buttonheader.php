<?php
include('inc/config.inc.php');
include('inc/DealUtils.php');
include('inc/WidgetUtils.php');
include('inc/i18n.php');

session_name("yiid_widget");
session_set_cookie_params(time()+17776000, "/", LikeSettings::COOKIE_DOMAIN);
session_start();
header('P3P: CP="DSP LAW"');
header('Pragma: no-cache');
header('Cache-Control: private, no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

if (isset($_GET['url']) && !empty($_GET['url'])) {
  $pUrl = urldecode($_GET['url']);
} else {
  $pUrl = urldecode($_SERVER['HTTP_REFERER']);
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

$pTitle = urldecode($_GET['title']);
$pPhoto = urldecode($_GET['photo']);
$pDescription = urldecode($_GET['description']);

$lClickback = ClickBackHelper::extractClickback($pUrl, $_SERVER['HTTP_REFERER']);
$lActiveDeal = DealUtils::dealActive($pUrl);

$pUserId = MongoSessionPeer::extractUserIdFromSession(LikeSettings::SF_SESSION_COOKIE);
$lSocialObjectArray = SocialObjectPeer::getDataForUrl($pUrl);
$lIsUsed = YiidActivityObjectPeer::actionOnObjectByUser($lSocialObjectArray['_id'], $pUserId, $lActiveDeal);
$lSocialObjectArray = SocialObjectPeer::recalculateCountsRespectingUser($lSocialObjectArray, $lIsUsed);
$lPopupUrl = LikeSettings::JS_POPUP_PATH."?ei_kcuf=".time();
$lShowFriends = false;
$lLimit = 6;
if($pUserId && $pSocialFeatures && $lSocialObjectArray['_id']) {
  $lShowFriends = true;
  $lLimit = $pFullShortVersion?6:8;
}

YiidStatsSingleton::trackVisit($pUrl);
StatsHelper::trackPageImpression($pUrl, $lClickback, $pUserId);
?>