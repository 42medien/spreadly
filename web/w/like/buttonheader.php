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

$pTitle = urldecode(@$_GET['title']);
$pPhoto = urldecode(@$_GET['photo']);
$pDescription = urldecode(@$_GET['description']);
$pTags = trim(urldecode(@$_GET['tags']));
// </Check Params>

$wu = new WidgetUtils($pUrl, $pTitle, $pDescription, $pPhoto, $pTags);

$lActiveDeal = $wu->getDeal();
$lActivityObject = $wu->getYiidActivity();

$pButtonClass = "";
if ($lActivityObject) {
  $pButtonClass = "disabled";
} elseif ($lActiveDeal) {
  $pButtonClass = "deal";
}

$lSocialObject = $wu->getSocialObject();

$lShowFriends = false;
if($wu->getUserId() && $pSocialFeatures && $lSocialObject['_id']) {
  $lShowFriends = true;
}

$wu->trackUser();

$lPopupUrl = LikeSettings::JS_POPUP_PATH."?ei_kcuf=".time()."&title=".urlencode($pTitle)."&description=".urlencode($pDescription)."&photo=".urlencode($pPhoto)."&tags=".urlencode($pTags)."&url=".urlencode($pUrl);