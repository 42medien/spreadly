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
$pTags = urldecode($_GET['tags']);

$lClickback = ClickBackHelper::extractClickback($pUrl, $_SERVER['HTTP_REFERER']);
$lActiveDeal = DealUtils::dealActive($pUrl);

$pUserId = MongoSessionPeer::extractUserIdFromSession(LikeSettings::SF_SESSION_COOKIE);
$lSocialObjectArray = SocialObjectPeer::getDataForUrl($pUrl);
$lActivityObject = YiidActivityObjectPeer::actionOnObjectByUser($lSocialObjectArray['_id'], $pUserId, $lActiveDeal);

$lPopupUrl = LikeSettings::JS_POPUP_PATH."?ei_kcuf=".time();
$lStaticUrl = LikeSettings::JS_STATIC_PATH."?ei_kcuf=".time();

$lIsDeal = false;
// check if user has an active deal
if ($lActiveDeal && $lActivityObject) {
  $lIsDeal = true;
// check if user has an active code
} elseif (($lActiveDeal && !YiidActivityObjectPeer::actionOnHostByUser($pUserId, $lActiveDeal)) &&
          ($lActiveDeal["is_unlimited"] == true || $lActiveDeal['remaining_coupon_quantity'] > 0)) {
  $lIsDeal = true;
} else {
  $lActivityObject = YiidActivityObjectPeer::actionOnObjectByUser($lSocialObjectArray['_id'], $pUserId);
}

if ($lActivityObject) {
  $lIsUsed = $lActivityObject['score'];
} else {
  $lIsUsed = false;
}

$lSocialObjectArray = SocialObjectPeer::recalculateCountsRespectingUser($lSocialObjectArray, $lIsUsed);

$lShowFriends = false;
$lLimit = 6;
if($pUserId && $pSocialFeatures && $lSocialObjectArray['_id']) {
  $lShowFriends = true;
  $lLimit = $pFullShortVersion?6:8;
}


YiidStatsSingleton::trackVisit($pUrl);
StatsHelper::trackPageImpression($pUrl, $lClickback, $pUserId);

if ($lIsDeal) {
  include("deal.php");
  exit;
}