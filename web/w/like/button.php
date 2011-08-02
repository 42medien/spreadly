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
    .A {
      display: inline-block;
      margin: 5px;
    }
    .B {
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
    .B:before{
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
    .B:focus, .B:hover{
      outline: none;
      background-position: -30% 20px;
      border: 1px solid hsl(333,42%,65%);
      border-top-color: hsl(333,42%,46%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(333,42%,50%,.3) inset, 0 0 4px 0 hsla(333,42%,30%,.5);
      text-shadow: 0 1px 1px hsla(333,42%,50%,.25), 0 -1px 1px #fff;
      -webkit-transition: box-shadow .3s ease-in, text-shadow .3s ease-in, background-position .6s ease-out;
      -moz-transition: box-shadow .3s ease-in, text-shadow .3s ease-in, background-position .6s ease-out;
    }

    .B:active {
      background-position: -30% 20px;
      background-color: hsla(333,42%,70%,1);
      color: #fff;
      border: 1px solid hsl(333,42%,30%);
      border-top-color: hsl(333,42%,30%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(333,42%,50%,.3) inset, 0 0 4px 0 hsla(333,42%,30%,.5);
      text-shadow: 0 0px 0px hsla(333,42%,50%,0), 0 0px 0px #fff;
    }

    .B:focus:before, .B:hover:before{
      opacity:.85;
      width: 14px;
      height: 14px;
      top:2px;
      left:2px;
      background-position: -1px -1px;*/
    }


    /* skin .ca*/

    .ca .B {
      color: hsl(199,81%,50%);
      border-color: hsl(199,81%,73%);
      border-bottom-color: hsl(199,81%,50%);
      border-top-color: hsl(199,81%,81%);
      box-shadow: 0 -1px 1px 1px hsla(199,81%,100%,.7) inset, 0 -4px 8px 0 hsla(199,81%,50%,.5) inset, 0 0 2px 8px hsla(199,81%,0%,0);
      text-shadow: 0 1px 1px #fff, 0 -1px 1px hsla(199,81%,50%,.25);
    }
    .ca .B:before{
      background-color: hsla(199,81%,50%,1);
      box-shadow: 0 1px 1px 0px hsla(199,81%,0%,.5) inset;
    }
    .ca .B:focus, .ca .B:hover{
      border-color: hsl(199,81%,65%);
      border-top-color: hsl(199,81%,46%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(199,81%,50%,.3) inset, 0 0 4px 0 hsla(199,81%,30%,.5);
      text-shadow: 0 1px 1px hsla(199,81%,50%,.25), 0 -1px 1px #fff;
    }
    /* skin .cb*/
    .cb .B {
      color: hsl(111,24%,50%);
      border-color: hsl(111,24%,73%);
      border-bottom-color: hsl(111,24%,50%);
      border-top-color: hsl(111,24%,81%);
      box-shadow: 0 -1px 1px 1px hsla(111,24%,100%,.7) inset, 0 -4px 8px 0 hsla(111,24%,50%,.5) inset, 0 0 2px 8px hsla(111,24%,0%,0);
      text-shadow: 0 1px 1px #fff, 0 -1px 1px hsla(111,24%,50%,.25);
    }
    .cb .B:before{
      background-color: hsla(111,24%,50%,1);
      box-shadow: 0 1px 1px 0px hsla(111,24%,0%,.5) inset;
    }
    .cb .B:focus, .cb .B:hover{
      border-color: hsl(111,24%,65%);
      border-top-color: hsl(111,24%,46%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(111,24%,50%,.3) inset, 0 0 4px 0 hsla(111,24%,30%,.5);
      text-shadow: 0 1px 1px hsla(111,24%,50%,.25), 0 -1px 1px #fff;
    }
    /* skin .cc*/
    .cc .B {
      color: hsl(302,54%,50%);
      border-color: hsl(302,54%,73%);
      border-bottom-color: hsl(302,54%,50%);
      border-top-color: hsl(302,54%,81%);
      box-shadow: 0 -1px 1px 1px hsla(302,54%,100%,.7) inset, 0 -4px 8px 0 hsla(302,54%,50%,.5) inset, 0 0 2px 8px hsla(302,54%,0%,0);
      text-shadow: 0 1px 1px #fff, 0 -1px 1px hsla(302,54%,50%,.25);
    }
    .cc .B:before{
      background-color: hsla(302,54%,50%,1);
      box-shadow: 0 1px 1px 0px hsla(302,54%,0%,.5) inset;
    }
    .cc .B:focus, .cc .B:hover{
      border-color: hsl(302,54%,65%);
      border-top-color: hsl(302,54%,46%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(302,54%,50%,.3) inset, 0 0 4px 0 hsla(302,54%,30%,.5);
      text-shadow: 0 1px 1px hsla(302,54%,50%,.25), 0 -1px 1px #fff;
    }
    /* skin .cd*/
    .cd .B {
      color: hsl(22,90%,50%);
      border-color: hsl(22,90%,73%);
      border-bottom-color: hsl(22,90%,50%);
      border-top-color: hsl(22,90%,81%);
      box-shadow: 0 -1px 1px 1px hsla(22,90%,100%,.7) inset, 0 -4px 8px 0 hsla(22,90%,50%,.5) inset, 0 0 2px 8px hsla(22,90%,0%,0);
      text-shadow: 0 1px 1px #fff, 0 -1px 1px hsla(22,90%,50%,.25);
    }
    .cd .B:before{
      background-color: hsla(22,90%,50%,1);
      box-shadow: 0 1px 1px 0px hsla(22,90%,0%,.5) inset;
    }
    .cd .B:focus, .cd .B:hover{
      border-color: hsl(22,90%,65%);
      border-top-color: hsl(22,90%,46%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(22,90%,50%,.3) inset, 0 0 4px 0 hsla(22,90%,30%,.5);
      text-shadow: 0 1px 1px hsla(22,90%,50%,.25), 0 -1px 1px #fff;
    }
    /* skin .ce*/
    .ce .B {
      color: hsl(349,79%,50%);
      border-color: hsl(349,79%,73%);
      border-bottom-color: hsl(349,79%,50%);
      border-top-color: hsl(349,79%,81%);
      box-shadow: 0 -1px 1px 1px hsla(349,79%,100%,.7) inset, 0 -4px 8px 0 hsla(349,79%,50%,.5) inset, 0 0 2px 8px hsla(349,79%,0%,0);
      text-shadow: 0 1px 1px #fff, 0 -1px 1px hsla(349,79%,50%,.25);
    }
    .ce .B:before{
      background-color: hsla(349,79%,50%,1);
      box-shadow: 0 1px 1px 0px hsla(349,79%,0%,.5) inset;
    }
    .ce .B:focus, .ce .B:hover{
      border-color: hsl(349,79%,65%);
      border-top-color: hsl(349,79%,46%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(349,79%,50%,.3) inset, 0 0 4px 0 hsla(349,79%,30%,.5);
      text-shadow: 0 1px 1px hsla(349,79%,50%,.25), 0 -1px 1px #fff;
    }
    /* skin .cf*/
    .cf .B {
      color: hsl(0,0%,50%);
      border-color: hsl(0,0%,73%);
      border-bottom-color: hsl(0,0%,50%);
      border-top-color: hsl(0,0%,81%);
      box-shadow: 0 -1px 1px 1px hsla(0,0%,100%,.7) inset, 0 -4px 8px 0 hsla(0,0%,50%,.5) inset, 0 0 2px 8px hsla(0,0%,0%,0);
      text-shadow: 0 1px 1px #fff, 0 -1px 1px hsla(0,0%,50%,.25);
    }
    .cf .B:before{
      background-color: hsla(0,0%,50%,1);
      box-shadow: 0 1px 1px 0px hsla(0,0%,0%,.5) inset;
    }
    .cf .B:focus, .cf .B:hover{
      border-color: hsl(0,0%,65%);
      border-top-color: hsl(0,0%,46%);
      box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(0,0%,50%,.3) inset, 0 0 4px 0 hsla(0,0%,30%,.5);
      text-shadow: 0 1px 1px hsla(0,0%,50%,.25), 0 -1px 1px #fff;
    }
  </style>
</head>
<body>
  <div class="A">
    <a class="B" href="<?php echo $wu->getPopupUrl() ?>" onclick="window.open(this.href, 'popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" target="_blank">Like</a>
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