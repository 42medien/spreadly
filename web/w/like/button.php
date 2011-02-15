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
  body { padding: 50px 100px; }
  </style>
</head>
<body>
  <br/><br/><br/>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button"><span class="like">&nbsp;</span><span class="count">53<?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>
<br/><br/><br/>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button disabled"><span class="like">&nbsp;</span><span class="count">53<?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>
<br/><br/><br/>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button deal"><span class="like">&nbsp;</span><span class="count">53<?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>
<br/><br/><br/>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button deal disabled"><span class="like">&nbsp;</span><span class="count">53<?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>
<br/><br/><br/>


</body>
</html>