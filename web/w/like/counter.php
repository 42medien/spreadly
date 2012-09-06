<?php
include('inc/config.inc.php');
include('inc/WidgetUtils.php');

session_name("spread_button");
session_set_cookie_params(time()+17776000, "/", LikeSettings::COOKIE_DOMAIN);
session_start();
header('P3P: CP="DSP LAW"');
header('Pragma: no-cache');
header('Cache-Control: private, no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

$wu = new WidgetUtils();
$wu->trackUser();
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>spreadly</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <style type="text/css">
  * {
    margin: 0;
    padding: 0;
    font-family: Corbel, 'Helvetica Neue', Arial, sans-serif;
    font-size: 12px;
    -moz-user-select:none;
    -webkit-user-select:none;
  }
  .container b {
    color: #aaa;
    text-shadow: 0 1px 0 hsla(0,0%,100%,1), 0 -1px 0 hsla(0,0%,0%,.4);
    box-shadow: 0 1px 0 0 hsla(0,0%,100%,1) inset;
    border: 1px solid #ccc;
    padding: 2px 4px 2px 6px;
    margin-left: 9px;
    background: #efefef;
    cursor: default;
    top: 4px;
    position: relative;
    border-radius: 3px;
    font-weight: normal;
    -webkit-transition: color 2s ease-out;
    -moz-transition: color 2s ease-out;
  }
  .container b:before {
    position: absolute;
    top: 4px;
    left: -6px;
    content: '';
    height: 8px;
    width: 8px;
    background: #efefef;
    border: 1px solid transparent;
    border-top-color: #ccc;
    border-left-color: #ccc;
    box-shadow: 0 1px 0 0 hsla(0,0%,100%,1) inset;
    transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
  }
  .button:hover+b, .button:hover+b:before {
    background: #fff;
    color: #666;
  }
  </style>

  <link rel="shortcut icon" href="//s3.amazonaws.com/spread.ly/img/favicon.ico" type="image/x-icon">
</head>
<body>
  <div class="container">
    <b><?php echo $wu->getActivityCount() ?></b>
  </div>
</body>
</html>
