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
  <title>spread.ly</title>

  <style type="text/css">
    *{
      margin: 0;
      padding: 0;
      font-family: Corbel, 'Helvetica Neue', Arial, sans-serif;
      font-size: 12px;
      -moz-user-select:none;
      -webkit-user-select:none;
    }
    /* default skin*/
    .container {
      display: inline-block;
      margin: 2px 5px;
    }
    .button {
      display: inline-block;
      position: relative;
      color: hsl(333,42%,50%);  /* #B44A7A */
      line-height: 18px;
      font-weight: bold;
      text-rendering: optimizeLegibility;
      -webkit-font-smoothing: antialiased;
      padding: 0 4px 0 21px;
      height: 18px;
      border: 1px solid hsl(333,42%,73%);
      border-bottom-color: hsl(333,42%,50%);
      border-top-color: hsl(333,42%,81%);
      border-radius: 3px;
      background: #fff url('./img/button/s.png') no-repeat 130% -20px;
      text-decoration: none;
      text-transform: uppercase;
      box-shadow: 0 -1px 1px 1px hsla(333,42%,100%,.7) inset, 0 -4px 8px 0 hsla(333,42%,50%,.5) inset, 0 0 2px 8px hsla(333,42%,0%,0);
      text-shadow: 0 1px 1px #fff, 0 -1px 1px hsla(333,42%,50%,.25);
      -webkit-transition: box-shadow .3s ease-out, text-shadow .3s ease-out, background-position .6s ease-out;
      -moz-transition: box-shadow .3s ease-out, text-shadow .3s ease-out, background-position .6s ease-out;
    }
    .button:before{
      background: hsla(333,42%,50%,1) url('./img/button/l.png') no-repeat 0px 0px;
      box-shadow: 0 1px 1px 0px hsla(333,42%,0%,.8) inset;
      content:'';
      width: 16px;
      height: 16px;
      display: block;
      position: absolute;
      top: 1px;
      left: 1px;
      border-radius: 2px;
      opacity:1;

    }
    .button:focus, .button:hover{
      outline: none;
      background-position: -30% 20px;
      border: 1px solid hsl(333,42%,65%);
      border-top-color: hsl(333,42%,46%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(333,42%,50%,.3) inset, 0 0 4px 0 hsla(333,42%,30%,.5);
      text-shadow: 0 1px 1px hsla(333,42%,50%,.25), 0 -1px 1px #fff;
      -webkit-transition: box-shadow .3s ease-in, text-shadow .3s ease-in, background-position .6s ease-out;
      -moz-transition: box-shadow .3s ease-in, text-shadow .3s ease-in, background-position .6s ease-out;
    }

    .button:active {
      background-position: -30% 20px;
      background-color: hsla(333,42%,70%,1);
      color: #fff;
      border: 1px solid hsl(333,42%,30%);
      border-top-color: hsl(333,42%,30%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(333,42%,50%,.3) inset, 0 0 4px 0 hsla(333,42%,30%,.5);
      text-shadow: 0 0px 0px hsla(333,42%,50%,0), 0 0px 0px #fff;
    }

    .button:focus:before, .button:hover:before{
      opacity:.85;
      width: 14px;
      height: 14px;
      top:2px;
      left:2px;
      background-position: -1px -1px;*/
    }

    .container b{
      color: #aaa;
      text-shadow: 0 1px 0 hsla(0,0%,100%,1), 0 -1px 0 hsla(0,0%,0%,.4);
      box-shadow: 0 1px 0 0 hsla(0,0%,100%,1) inset;
      border: 1px solid #ccc;
      padding: 2px 4px 2px 6px;
      margin-left: 9px;
      background: #efefef;
      cursor: default;
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
  <div class="container">
    <a class="button" href="<?php echo $wu->getPopupUrl() ?>" onclick="window.open(this.href, 'popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" target="_blank">Like</a>
    <?php if ($wu->showCounter()) { ?><b><?php echo $wu->getActivityCount() ?></b><?php } ?>
  </div>
  <?php if ($wu->showFriends()): ?>
 	<script type="text/javascript" src="/js/100_main/include/button-<?php echo LikeSettings::RELEASE_NAME; ?>.js"></script>
  <script type="text/javascript">
		YiidFriends.aGetAction = "/api/load_friends";
		YiidFriends.init("<?php echo $wu->getSocialObjectId(); ?>");
	</script>

  <div id="friends">

	</div>
  <?php endif; ?>
</body>
</html>