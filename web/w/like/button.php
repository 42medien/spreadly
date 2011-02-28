<?php
include('inc/config.inc.php');
include('inc/WidgetUtils.php');

session_name("yiid_widget");
session_set_cookie_params(time()+17776000, "/", LikeSettings::COOKIE_DOMAIN);
session_start();
header('P3P: CP="DSP LAW"');
header('Pragma: no-cache');
header('Cache-Control: private, no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

try {
  $wu = new WidgetUtils();
  $wu->trackUser();
} catch (Exception $e) {
  echo "ups, our server has a problem, if you get this message once again, please let us know";
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>spread.ly</title>
  <!--[if lte IE 6]>
    <style type="text/css">a { behavior: url(./../js/widget/iepngfix.htc); }</style>
  <![endif]-->
  <style type="text/css">
  * { margin: 0; padding: 0; }
  a.button {
    cursor: pointer;
    display: block;
    width: 101px;
    height: 22px;
    line-height: 22px;
    position: relative;
    overflow: hidden;
    color: #782a4f;
    font-size: 10px;
    text-decoration: none;
  }
  a.button span {
    position: absolute;
    display: block;
    height: 22px;
    background: transparent url('/img/sprites/spreadly_button_sprite.png') no-repeat scroll 0 0;
    font-family: Tahoma, Verdana, Arial, sans-serif;
  }
  a.button span.like {
    width: 60px;
    left: 0;
  }
  a.button span.count {
    width: 41px;
    left: 60px;
    text-align: center;
    background-position: 0 -600px;
  }
  a.button span.like:hover {
    background-position: 0 -100px;
  }
  a.button.disabled span.like {
    background-position: 0 -200px;
  }
  a.deal span.like {
    background-position: 0 -300px;
  }
  a.deal span.like:hover {
    background-position: 0 -400px;
  }
  a.deal.disabled span.like {
    background-position: 0 -500px;
  }
  div.text {
    position: absolute;
    top: 0;
    font-family: Tahoma, Verdana, Arial, sans-serif;
    line-height: 22px;
    color: #444;
    font-size: 10px;
    left: 110px;
    white-space: nowrap;
  }
  ul.icons {
    list-style-type: none;
    margin-top: 3px;
    height: 30px;
    width: 100px;
    overflow: hidden;
  }
  ul.icons li {
    float: left;
    margin-right: 3px;
  }
  ul.icons li.last {
    margin-right: 0px;
  }
  ul.icons a img {
    height: 30px;
    width: 30px;
  }
  </style>
</head>
<body>
  <a href="<?php echo $wu->getPopupUrl() ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" target="_blank" class="button <?php echo $wu->getButtonClass(); ?>"><span class="like">&nbsp;</span><span class="count"><?php echo intval($wu->getActivityCount()) ?></span></a>
  <?php if ($wu->getDeal()): ?>
    <div class="text"><?php echo $lActiveDeal['button_wording']; ?></div>
  <?php endif; ?>
  <?php if ($wu->showFriends()): ?>
  <ul class="icons">
    <li><a><img src="http://a3.twimg.com/profile_images/1170987730/final_197_normal.jpg" /></a></li>
    <li><a><img src="http://a3.twimg.com/profile_images/1170987730/final_197_normal.jpg" /></a></li>
    <li class="last"><a><img src="http://a3.twimg.com/profile_images/1170987730/final_197_normal.jpg" /></a></li>
  </ul>
  <?php endif; ?>
</body>
</html>