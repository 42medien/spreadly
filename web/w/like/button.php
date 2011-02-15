<?php include("buttonheader.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>spread.ly</title>
  <!--[if IE 7]>
    <script type="text/javascript" src="./../js/widget/iepngfix_tilebg.js"></script>
  <![endif]-->
  <!--[if lte IE 6]>
    <style type="text/css">a { behavior: url(./../js/widget/iepngfix.htc); }</style>
  <![endif]-->
  <style type="text/css">
  * { margin: 0; padding: 0; }
  a.button {
    display: block;
    position: relative;
    width: 101px;
    height: 22px;
    clear: right;
    text-decoration: none;
    color: #782a4f;
    font-family: Tahoma, Verdana, sans-serif;
    font-size: 10px;
    background: transparent url('/img/sprites/spreadly_button_sprite.png') no-repeat scroll 0 0;
  }
  a.button span {
    display: block;
    width: 41px;
    height: 22px;
    position: absolute;
    right: 0;
    padding-top: 3px;
    text-align: center;
    background: transparent url('/img/sprites/spreadly_button_sprite.png') no-repeat scroll 0 -600px;
  }
  a.button:hover {
   background-position: 0 -100px;
  }
  a.button.disabled {
   background-position: 0 -200px;
  }
  a.deal {
   background-position: 0 -300px;
  }
  a.deal:hover {
   background-position: 0 -400px;
  }
  a.deal.disabled {
   background-position: 0 -500px;
  }
  body { padding: 50px 100px; }
  </style>
</head>
<body>
  <br/><br/><br/>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button"><span>53<?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>
<br/><br/><br/>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button deal"><span>73<?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>
<br/><br/><br/>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button disabled"><span>834<?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>
<br/><br/><br/>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button deal disabled"><span>283<?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>


</body>
</html>