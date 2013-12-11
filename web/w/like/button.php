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
    *{
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
      top: -6px;
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
    a, a:hover, a:visited, a img {
	  border: 0px none;
	  text-decoration: none;
	}
    <?php if ($wu->showFriends()): ?>
    ul.icons {
      list-style-type: none;
      margin-top: 3px;
      height: 30px;
      width: 100px;
      overflow: hidden;
      margin-left: 6px;
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
    <?php endif; ?>
  </style>

  <link rel="shortcut icon" href="//s3.amazonaws.com/spread.ly/img/favicon.ico" type="image/x-icon">
</head>
<body>
  <div class="container">
    <a class="button" href="<?php echo $wu->getPopupUrl() ?>" title="share it with your friends and get incentives" onclick="window.open(this.href, 'popup', 'width=580,height=600,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" target="_blank">
      <img src="<?php echo LikeSettings::BUTTON_URL ?>/img/button/28/fb.png" alt="share it with your facebook friends">
      <img src="<?php echo LikeSettings::BUTTON_URL ?>/img/button/28/tw.png" alt="share it with your twitter friends">
      <img src="<?php echo LikeSettings::BUTTON_URL ?>/img/button/28/li.png" alt="share it with your linkedin friends">
      <img src="<?php echo LikeSettings::BUTTON_URL ?>/img/button/28/sl.png" alt="...and get a deal">
      <?php //echo $wu->getLabel(); ?>
    </a>
    <?php if ($wu->showCounter()) { ?><b><?php echo $wu->getActivityCount() ?></b><?php } ?>
  </div>
  <?php if ($wu->showFriends()): ?>
  <script type="text/javascript">
	  var YiidUtils={createXMLHttpRequest:function(){var lXhttp=null;if(window.ActiveXObject){try{lXhttp=new ActiveXObject("MSXML2.XMLHTTP");}catch(e){try{lXhttp=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){lXhttp=false;}}}else if(window.XMLHttpRequest){try{lXhttp=new XMLHttpRequest();}catch(e){lXhttp=false;}}
	  return lXhttp;}};var YiidFriends={aGetAction:"",init:function(pObjectId,pUserId){YiidFriends.getFriends(pObjectId,pUserId);},getFriends:function(pObjectId,pUserId){var lXhttp=YiidUtils.createXMLHttpRequest();try{var lQuery=encodeURI('so_id='+pObjectId+'&u_id='+pUserId);lXhttp.open("POST",YiidFriends.aGetAction,true);lXhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");lXhttp.setRequestHeader("Content-length",lQuery.length);lXhttp.setRequestHeader("Connection","close");lXhttp.onreadystatechange=function(){if(lXhttp.readyState==4){if(lXhttp.status!=200){}else{YiidFriends.handleRequest(lXhttp);}}};lXhttp.send(lQuery);}catch(lError){}},handleRequest:function(pXhttp){YiidFriends.showFriends(pXhttp.responseText);},showFriends:function(pHtml){var lContainer=document.getElementById("friends");if(lContainer!==undefined){lContainer.innerHTML=pHtml;}else{YiidFriends.showFriends(pHtml);}
	  return true;}};

		YiidFriends.aGetAction = "<?php echo LikeSettings::JS_POPUP_PATH ?>api/load_friends";
		YiidFriends.init("<?php echo $wu->getSocialObjectId(); ?>", "<?php echo $wu->getUserId(); ?>");
	</script>
  <div id="friends">

	</div>
  <?php endif; ?>
</body>
</html>
